<?php

namespace Tests\Feature;

use App\Http\Middleware\Captcha;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ProfileService;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_rolls_back_when_profile_creation_fails(): void
    {
        $this->withoutMiddleware(Captcha::class);
        Event::fake([Registered::class]);
        $profileRepository = $this->createMock(ProfileRepositoryInterface::class);
        $profileRepository->expects($this->once())->method('initialize')->willThrowException(new \RuntimeException('Profile unavailable'));
        $this->instance(ProfileRepositoryInterface::class, $profileRepository);

        $data = [
            'username' => 'driver', 'email' => 'driver@example.test',
            'password' => 'secret123', 'password_confirmation' => 'secret123',
        ];
        $this->postJson(route('register'), $data)->assertServerError();
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('profiles', 0);
        Event::assertNotDispatched(Registered::class);
    }

    public function test_registration_initializes_a_private_profile(): void
    {
        $this->withoutMiddleware(Captcha::class);
        Event::fake([Registered::class]);
        $this->postJson(route('register'), [
            'username' => 'driver', 'email' => 'driver@example.test',
            'password' => 'secret123', 'password_confirmation' => 'secret123',
        ])->assertCreated();
        $user = User::where('username', 'driver')->sole();
        $this->assertFalse($user->profile->public);
        $this->assertStringEndsWith('/storage/avatars/user.svg', $user->profile->avatar);
        Event::assertDispatched(Registered::class);
    }

    public function test_social_sign_in_uses_the_default_avatar_and_preserves_profile_edits(): void
    {
        $controller = app(\App\Http\Controllers\Auth\LoginController::class);
        $provider = (object) ['id' => 'social-driver', 'email' => 'social@example.test', 'avatar' => null];
        $user = $controller->findOrCreateUser($provider, 'google');
        $this->assertFalse($user->profile->public);
        $this->assertStringEndsWith('/storage/avatars/user.svg', $user->profile->avatar);

        app(ProfileService::class)->addUserAvatar($user->id, '/my-avatar.jpg');
        $provider->avatar = 'https://example.test/provider.jpg';
        $returningUser = $controller->findOrCreateUser($provider, 'google');

        $this->assertTrue($returningUser->is($user));
        $this->assertSame('/my-avatar.jpg', $returningUser->profile->avatar);
    }

    public function test_settings_recover_a_missing_profile_without_overwriting_existing_data(): void
    {
        (new \SeoTableSeeder())->run();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $service = app(ProfileService::class);
        $this->actingAs($user)->get(route('user.settings', $user->username))->assertOk();

        $service->updateVisibility($user->id, true);
        $service->updateDetails($user->id, ['city' => 'Казань', 'public' => false, 'avatar' => '/unexpected.jpg']);
        $profile = $service->initialize($user, '/provider.jpg');

        $this->assertTrue($profile->public);
        $this->assertSame('Казань', $profile->city);
        $this->assertStringEndsWith('/storage/avatars/user.svg', $profile->avatar);
        $this->assertDatabaseCount('profiles', 1);
    }

    public function test_profile_changes_refresh_cached_users_and_posts_only_after_commit(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $service = app(ProfileService::class);
        $service->initialize($user, '/old.jpg');
        \App\Post::factory()->for($user)->create();

        $users = app(UserRepositoryInterface::class);
        $posts = app(PostRepositoryInterface::class);
        $this->assertSame('/old.jpg', $users->getCurrentUserWithProfile($user->id)['profile']['avatar']);
        $this->assertSame('/old.jpg', $users->getVerifiedUsers()[0]['profile']['avatar']);
        $this->assertSame('/old.jpg', $posts->getTopPosts(1)[0]['user']['profile']['avatar']);
        $version = Cache::get('post-listings-version');

        DB::beginTransaction();
        try {
            $service->addUserAvatar($user->id, '/discarded.jpg');
            $this->assertSame($version, Cache::get('post-listings-version'));
        } finally {
            DB::rollBack();
        }

        $this->assertSame('/old.jpg', $users->getVerifiedUsers()[0]['profile']['avatar']);
        $service->addUserAvatar($user->id, '/new.jpg');
        $this->assertSame('/new.jpg', $users->getCurrentUserWithProfile($user->id)['profile']['avatar']);
        $this->assertSame('/new.jpg', $users->getVerifiedUsers()[0]['profile']['avatar']);
        $this->assertSame('/new.jpg', $posts->getTopPosts(1)[0]['user']['profile']['avatar']);

        $updatedVersion = Cache::get('post-listings-version');
        $service->addUserAvatar($user->id, '/new.jpg');
        $this->assertSame($updatedVersion, Cache::get('post-listings-version'));
    }

    public function test_avatar_crop_is_validated_and_replacement_gets_a_new_url(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['email_verified_at' => now()]);
        app(ProfileService::class)->initialize($user);
        $route = route('user.avatar.upload');
        $upload = fn () => [
            'avatar_upload' => UploadedFile::fake()->image('avatar.png', 100, 100),
            'x' => 30, 'y' => 30, 'width' => 50, 'height' => 50,
        ];

        $this->actingAs($user)->postJson($route, array_replace($upload(), ['width' => 71]))
            ->assertUnprocessable()->assertJsonValidationErrors('avatar_upload');
        Storage::disk('public')->assertMissing("avatars/{$user->id}.jpg");

        $first = $this->postJson($route, $upload())->assertOk()->json('url');
        $second = $this->postJson($route, array_replace($upload(), ['height' => 40]))->assertOk()->json('url');
        $this->assertNotSame($first, $second);
        $this->assertSame($second, $user->profile()->firstOrFail()->avatar);
    }

    public function test_rendering_a_birth_date_does_not_change_the_global_locale(): void
    {
        $locale = Carbon::getLocale();
        $profile = app(ProfileService::class)->initialize(User::factory()->create());
        $this->assertNull($profile->birth_date);
        $profile->birth_date = now()->subYears(30)->subMonth()->toDateString();

        $this->assertStringContainsString('30 лет', $profile->birth_date);
        $this->assertSame($locale, Carbon::getLocale());
    }
}
