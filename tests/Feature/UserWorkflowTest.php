<?php

namespace Tests\Feature;

use App\Album;
use App\Events\ConfirmFriendRequest;
use App\Events\FriendRequestSent;
use App\Events\MessageSaved;
use App\User;
use App\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_directory_excludes_the_viewer_and_reflects_profile_visibility(): void
    {
        (new \SeoTableSeeder())->run();
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        $privateUser = $this->user('private-user', false);

        $this->actingAs($alice)->get(route('users', $alice->username))->assertOk()
            ->assertViewHas('profiles', fn (array $profiles) => array_column($profiles, 'user_id') === [$bob->id]);
        $this->actingAs($bob)->get(route('users', $bob->username))->assertOk()
            ->assertViewHas('profiles', fn (array $profiles) => array_column($profiles, 'user_id') === [$alice->id]);

        $settings = route('user.settings.update', $alice->username);
        $this->patch($settings, ['public' => false])->assertForbidden();
        $this->actingAs($alice)->get(route('user.settings', $alice->username))->assertOk();
        $this->patch($settings, ['public' => false])->assertRedirect(route('user.settings', $alice->username));
        $this->actingAs($bob)->get(route('users', $bob->username))->assertOk()->assertViewHas('profiles', []);
        $this->get(route('user.profile', $privateUser->username))->assertForbidden();
        $this->get(route('user.profile', $bob->username))->assertOk()->assertSee('js/app.js');
    }

    public function test_request_can_be_confirmed_only_by_its_recipient_and_events_are_sent_once(): void
    {
        (new \SeoTableSeeder())->run();
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        $visitor = $this->user('visitor');
        Event::fake([FriendRequestSent::class, ConfirmFriendRequest::class]);

        $this->actingAs($alice)->postJson(route('users.store'), ['friend_id' => $bob->id])->assertOk();
        $this->postJson(route('users.store'), ['friend_id' => $bob->id])->assertOk();
        $this->postJson(route('user.requests.confirmation'), ['id' => $bob->id])->assertNoContent();
        $this->assertDatabaseCount('friends', 2);
        $this->assertDatabaseMissing('friends', ['confirmed' => true]);

        $this->actingAs($bob)->get(route('user.requests', $bob->username))->assertOk()
            ->assertViewHas('friendRequests', fn ($requests) => $requests->pluck('user_id')->all() === [$alice->id]);
        $this->postJson(route('user.requests.confirmation'), ['id' => $alice->id])->assertNoContent();
        $this->postJson(route('user.requests.confirmation'), ['id' => $alice->id])->assertNoContent();

        $this->actingAs($visitor)->get(route('user.friends', $alice->username))->assertOk()
            ->assertViewHas('friendList', fn ($friends) => $friends->pluck('user_id')->all() === [$bob->id]);
        Event::assertDispatchedTimes(FriendRequestSent::class, 1);
        Event::assertDispatchedTimes(ConfirmFriendRequest::class, 1);
    }

    public function test_message_is_sent_as_the_authenticated_user_and_appears_in_the_dialogue(): void
    {
        (new \SeoTableSeeder())->run();
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        Event::fake([FriendRequestSent::class, ConfirmFriendRequest::class, MessageSaved::class]);

        $payload = ['username' => $bob->username, 'friend_id' => $bob->id, 'message' => 'Hello Bob'];
        $url = route('message.store', $alice->username);
        $this->actingAs($alice)->postJson($url, $payload)->assertForbidden();
        $this->postJson(route('users.store'), ['friend_id' => $bob->id])->assertOk();
        $this->actingAs($bob)->postJson(route('user.requests.confirmation'), ['id' => $alice->id])->assertNoContent();

        $this->actingAs($alice)->postJson($url, $payload)->assertOk()->assertJsonPath('username', 'alice');
        $this->assertDatabaseHas('messages', ['user_id' => $alice->id, 'friend_id' => $bob->id]);
        $this->get(route('user.messages', $alice->username))->assertOk();
        $this->get(route('user.friend.messages', [$alice->username, $bob->username]))
            ->assertOk()->assertSee('Hello Bob')->assertSee($url);
        Event::assertDispatchedTimes(MessageSaved::class, 1);
    }

    public function test_public_album_is_loaded_from_its_owner_and_can_only_be_edited_by_the_owner(): void
    {
        (new \SeoTableSeeder())->run();
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        $album = Album::create(['name' => 'photos', 'path' => 'alice-photos', 'user_id' => $alice->id]);
        Album::create(['name' => 'photos', 'path' => 'bob-photos', 'user_id' => $bob->id]);
        $parameters = [$alice->username, $album->name];

        $this->actingAs($bob)->get(route('user.albums.index', $alice->username))->assertOk()
            ->assertDontSee('class="right create-album"', false);
        $this->get(route('user.albums.show', $parameters))->assertOk()
            ->assertViewHas('album', fn (Album $shown) => $shown->is($album));
        $this->get(route('user.albums.show', [$alice->username, 'missing']))->assertNotFound();
        $this->get(route('user.albums.edit', $parameters))->assertForbidden();
        $this->actingAs($alice)->get(route('user.albums.edit', $parameters))->assertOk();
    }

    public function test_album_photo_upload_and_deletion_are_scoped_to_the_owner(): void
    {
        Storage::fake('public');
        (new \SeoTableSeeder())->run();
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        $album = Album::create(['name' => 'photos', 'path' => 'alice-photos', 'user_id' => $alice->id]);
        $upload = [
            'album_name' => $album->name,
            'images_upload' => [UploadedFile::fake()->image('photo.png')],
            'username' => $alice->username,
        ];

        $this->actingAs($bob)->post(route('user.albums.image.upload'), $upload)->assertNotFound();
        $this->actingAs($alice)->post(route('user.albums.image.upload'), $upload)->assertCreated();
        $photo = Image::where('album_id', $album->id)->sole();
        Storage::disk('public')->assertExists($photo->path);
        $this->get(route('user.albums.show', [$alice->username, $album->name]))
            ->assertOk()->assertSee($photo->url);

        $delete = route('user.image.delete', ['album' => $album->id, 'id' => $photo->id]);
        $this->actingAs($bob)->deleteJson($delete)->assertNotFound();
        $this->actingAs($alice)->deleteJson($delete)->assertOk();
        Storage::disk('public')->assertMissing($photo->path);
        $this->assertModelMissing($photo);
    }

    public function test_avatar_upload_updates_the_profile_and_invalidates_its_cache(): void
    {
        Storage::fake('public');
        $alice = $this->user('alice');
        $users = app(\App\Services\UserService::class);
        $this->assertSame('/avatar.png', $users->getCurrentUserWithProfile($alice->id)['profile']['avatar']);

        $response = $this->actingAs($alice)->post(route('user.avatar.upload'), [
            'avatar_upload' => UploadedFile::fake()->image('avatar.png', 100, 100),
            'x' => 0,
            'y' => 0,
            'width' => 50,
            'height' => 50,
        ])->assertOk();

        Storage::disk('public')->assertExists("avatars/{$alice->id}.jpg");
        $this->assertSame($response->json('url'), $users->getCurrentUserWithProfile($alice->id)['profile']['avatar']);
    }

    public function test_editor_attachment_is_saved_to_the_authenticated_users_album(): void
    {
        Storage::fake('public');
        $alice = $this->user('alice');
        $bob = $this->user('bob');

        $response = $this->actingAs($alice)->post(route('user.image.upload'), [
            'upload_image_form_input' => UploadedFile::fake()->image('attachment.png'),
            'type' => 'post',
            'username' => $bob->username,
        ])->assertOk();

        $image = Image::where('url', $response->json('url'))->sole();
        $this->assertSame($alice->id, $image->album->user_id);
        $this->assertSame('posts', $image->album->name);
        Storage::disk('public')->assertExists($image->path);
    }

    private function user(string $username, bool $public = true): User
    {
        $id = DB::table('users')->insertGetId([
            'username' => $username,
            'email' => $username.'@example.test',
            'email_verified_at' => now(),
        ]);
        DB::table('profiles')->insert(['user_id' => $id, 'avatar' => '/avatar.png', 'public' => $public]);

        return User::findOrFail($id);
    }
}
