<?php

namespace Tests\Feature;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\RatingService;
use App\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RatingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_add_remove_and_restore_only_their_own_vote(): void
    {
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        $post = $this->createPost($alice);
        $otherPost = $this->createPost($alice, 'other');
        $this->vote($otherPost, $alice, 1);

        $this->actingAs($alice)->postJson(route('rating.post'), ['id' => $post])->assertOk()->assertContent('1');
        $this->actingAs($bob)->postJson(route('rating.post'), ['id' => (string) $post])->assertOk()->assertContent('2');
        $this->postJson(route('rating.post'), ['id' => $post])->assertOk()->assertContent('1');
        $this->assertDatabaseHas('ratings', ['post_id' => $post, 'user_id' => $alice->id, 'rating' => 1]);
        $this->assertDatabaseHas('ratings', ['post_id' => $post, 'user_id' => $bob->id, 'rating' => 0]);

        $this->postJson(route('rating.post'), ['id' => $post])->assertOk()->assertContent('2');
        $this->assertDatabaseCount('ratings', 3);
        $this->assertSame(1, app(RatingService::class)->calculatePostRating($otherPost));
    }

    public function test_rating_requires_authentication_and_a_published_post(): void
    {
        $user = $this->user('alice');
        $draft = $this->createPost($user, 'draft', false);
        $archived = $this->createPost($user, 'archived');
        DB::table('posts')->where('id', $archived)->update(['archived_at' => now()]);

        $url = route('rating.post');
        $this->postJson($url, ['id' => $draft])->assertUnauthorized();
        $this->actingAs($user)->postJson($url, ['id' => 0])->assertUnprocessable()->assertJsonValidationErrors('id');
        $this->postJson($url, ['id' => 'invalid'])->assertUnprocessable()->assertJsonValidationErrors('id');
        foreach ([$draft, $archived, 100000] as $post) {
            $this->postJson($url, ['id' => $post])->assertNotFound();
        }
        $this->assertDatabaseCount('ratings', 0);
    }

    public function test_committed_votes_refresh_warmed_post_listings(): void
    {
        $user = $this->user('alice');
        $post = $this->createPost($user);
        $repository = app(PostRepositoryInterface::class);
        $this->assertSame([], $repository->getAllPublishedPosts()[0]['rating']);
        $this->assertSame([], $repository->getPostsByMonth()[0]['rating']);
        $this->assertSame([], $repository->getTopPosts(3)[0]['rating']);

        $service = app(RatingService::class);
        $this->assertSame(1, $service->toggleRating($post, $user->id));
        $this->assertEquals(1, $repository->getAllPublishedPosts()[0]['rating'][0]['rating']);
        $this->assertEquals(1, $repository->getPostsByMonth()[0]['rating'][0]['rating']);
        $this->assertEquals(1, $repository->getTopPosts(3)[0]['rating'][0]['rating']);

        $this->assertSame(0, $service->toggleRating($post, $user->id));
        $this->assertEquals(0, $repository->getTopPosts(3)[0]['rating'][0]['rating']);
    }

    public function test_a_rolled_back_vote_preserves_the_cached_listings(): void
    {
        $user = $this->user('alice');
        $post = $this->createPost($user);
        $repository = app(PostRepositoryInterface::class);
        $repository->getAllPublishedPosts();
        $repository->getTopPosts(3);
        $cacheVersion = Cache::get('post-listings-version');

        DB::beginTransaction();
        try {
            $this->assertSame(1, app(RatingService::class)->toggleRating($post, $user->id));
            $this->assertSame($cacheVersion, Cache::get('post-listings-version'));
        } finally {
            DB::rollBack();
        }

        $this->assertDatabaseCount('ratings', 0);
        $this->assertTrue(Cache::has('latest-posts'));
        $this->assertSame($cacheVersion, Cache::get('post-listings-version'));
    }

    public function test_migration_keeps_the_latest_row_per_user_and_enforces_uniqueness(): void
    {
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        $post = $this->createPost($alice);
        $migration = require database_path('migrations/2026_11_26_000000_enforce_unique_post_ratings.php');
        $migration->down();
        $this->vote($post, $alice, 1);
        $this->vote($post, $alice, 0);
        $this->vote($post, $bob, 1);

        $migration->up();

        $this->assertDatabaseCount('ratings', 2);
        $this->assertDatabaseHas('ratings', ['post_id' => $post, 'user_id' => $alice->id, 'rating' => 0]);
        $this->assertSame(1, app(RatingService::class)->calculatePostRating($post));
        $this->expectException(UniqueConstraintViolationException::class);
        $this->vote($post, $alice, 1);
    }

    public function test_vote_indicator_uses_the_current_users_vote_on_cards_and_the_post_page(): void
    {
        (new \SeoTableSeeder())->run();
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        DB::table('profiles')->insert(['user_id' => $alice->id, 'avatar' => '/avatar.png', 'public' => true]);
        $post = $this->createPost($alice);
        $page = route('posts.show', 'rated-post');
        $listing = route('posts.index');

        $this->get($page)->assertOk()->assertDontSee('aria-pressed=', false);
        $this->actingAs($alice)->get($listing)->assertOk()->assertSee('aria-pressed="false"', false);
        $this->postJson(route('rating.post'), ['id' => $post])->assertOk()->assertContent('1')
            ->assertHeader('X-Rating-Voted', '1');
        $this->get($page)->assertOk()->assertSee('aria-pressed="true"', false);
        $this->get($listing)->assertSee('aria-pressed="true"', false);
        $this->get(route('posts.rated'))->assertOk()
            ->assertSee(route('posts.rated.period', 'week'))->assertSee(route('posts.rated.period', 'month'));
        $this->actingAs($bob)->get($page)->assertOk()->assertSee('aria-pressed="false"', false);
        $this->get($listing)->assertSee('aria-pressed="false"', false);

        $this->actingAs($alice)->postJson(route('rating.post'), ['id' => $post])
            ->assertOk()->assertContent('0')->assertHeader('X-Rating-Voted', '0');
        $this->get($page)->assertSee('aria-pressed="false"', false);
    }

    public function test_rankings_count_only_active_votes_in_the_requested_window(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 26)->setTime(15, 0));
        $alice = $this->user('alice');
        $bob = $this->user('bob');
        DB::table('profiles')->insert(['user_id' => $alice->id, 'avatar' => '/avatar.png', 'public' => true]);
        $weekPost = $this->createPost($alice, 'week-post');
        $monthPost = $this->createPost($alice, 'month-post');
        $oldPost = $this->createPost($alice, 'old-post');
        $draft = $this->createPost($alice, 'draft', false);
        $archived = $this->createPost($alice, 'archived');
        DB::table('posts')->where('id', $archived)->update(['archived_at' => now()]);

        DB::table('ratings')->insert([
            ['post_id' => $weekPost, 'user_id' => $alice->id, 'rating' => 1, 'updated_at' => now()->subDays(7)],
            ['post_id' => $weekPost, 'user_id' => $bob->id, 'rating' => 0, 'updated_at' => now()],
            ['post_id' => $monthPost, 'user_id' => $alice->id, 'rating' => 1, 'updated_at' => now()->subDays(7)->subSecond()],
            ['post_id' => $monthPost, 'user_id' => $bob->id, 'rating' => 1, 'updated_at' => now()->subDays(30)],
            ['post_id' => $oldPost, 'user_id' => $alice->id, 'rating' => 1, 'updated_at' => now()->subDays(30)->subSecond()],
            ['post_id' => $draft, 'user_id' => $alice->id, 'rating' => 1, 'updated_at' => now()],
            ['post_id' => $archived, 'user_id' => $alice->id, 'rating' => 1, 'updated_at' => now()],
        ]);

        $week = route('posts.rated.period', 'week');
        $month = route('posts.rated.period', 'month');
        $this->get($week)->assertOk()->assertSee($month);
        $this->assertSame([$weekPost => 1], $this->rankings($week));
        $this->assertSame([$monthPost => 2, $weekPost => 1], $this->rankings($month));
        config(['pagination.postsPerPage' => 1]);
        $this->get($month)->assertOk()->assertSee($month.'?page=2');
        $this->assertSame([$weekPost => 1], $this->rankings($month.'?page=2'));


        $this->actingAs($alice)->postJson(route('rating.post'), ['id' => $weekPost])->assertHeader('X-Rating-Voted', '0');
        $this->assertSame([], $this->rankings($week));
        $this->postJson(route('rating.post'), ['id' => $oldPost])->assertHeader('X-Rating-Voted', '0');
        $this->postJson(route('rating.post'), ['id' => $oldPost])->assertHeader('X-Rating-Voted', '1');
        $this->assertSame([$oldPost => 1], $this->rankings($week));
    }

    private function rankings(string $url): array
    {
        $posts = $this->get($url)->assertOk()->viewData('posts')->items();

        return array_column($posts, 'period_rating_count', 'id');
    }

    private function user(string $username): User
    {
        $id = DB::table('users')->insertGetId(['username' => $username, 'email' => $username.'@example.test']);

        return User::findOrFail($id);
    }

    private function createPost(User $author, string $slug = 'rated-post', bool $published = true): int
    {
        return DB::table('posts')->insertGetId([
            'user_id' => $author->id, 'slug' => $slug, 'name' => $slug, 'title' => $slug,
            'description' => '', 'caption' => '', 'body' => '', 'image_path' => '', 'views' => 0,
            'is_published' => $published, 'date_published' => $published ? now() : null,
        ]);
    }

    private function vote(int $post, User $user, int $rating): void
    {
        DB::table('ratings')->insert(['post_id' => $post, 'user_id' => $user->id, 'rating' => $rating]);
    }
}
