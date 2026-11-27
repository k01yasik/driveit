<?php

namespace Tests\Feature;

use App\Comment;
use App\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostSortingTest extends TestCase
{
    use RefreshDatabase;

    private User $author;

    protected function setUp(): void
    {
        parent::setUp();

        (new \SeoTableSeeder())->run();
        $this->author = User::factory()->create();
        DB::table('profiles')->insert(['user_id' => $this->author->id, 'avatar' => '/avatar.png', 'public' => true]);
    }

    public function test_rating_counts_active_votes_and_page_links_use_the_canonical_routes(): void
    {
        config(['pagination.postsPerPage' => 1]);
        $first = $this->createPost('first', ['updated_at' => now()->subDay()]);
        $second = $this->createPost('second');
        $third = $this->createPost('third');
        $archived = $this->createPost('archived', ['archived_at' => now()]);
        $draft = $this->createPost('draft', ['is_published' => false]);
        foreach ([$first, $second, $archived, $draft] as $post) {
            $this->vote($post, 1);
        }
        $this->vote($third, 0);

        $this->get(route('posts.rated'))->assertOk()->assertViewHas('posts', function ($posts) use ($second) {
            return $posts->total() === 3 && $posts->items()[0]['id'] === $second->id;
        });

        $pageTwo = route('best.rated.paginate', 2);
        $pageThree = route('best.rated.paginate', 3);
        $this->get($pageTwo)->assertOk()
            ->assertViewHas('posts', fn ($posts) => $posts->items()[0]['id'] === $first->id)
            ->assertSee('href="'.route('posts.rated').'" rel="prev"', false)
            ->assertSee('href="'.$pageThree.'" rel="next"', false);
        $this->get($pageThree)->assertOk()->assertViewHas('posts', fn ($posts) => $posts->items()[0]['id'] === $third->id);
    }

    public function test_comment_and_view_rankings_are_stable_for_equal_counts(): void
    {
        config(['pagination.postsPerPage' => 2]);
        $first = $this->createPost('first', ['views' => 50]);
        $second = $this->createPost('second', ['updated_at' => $first->updated_at, 'views' => 50]);
        $third = $this->createPost('third', ['views' => 40]);
        $this->comment($first, true);
        $this->comment($second, true);
        $this->comment($third, false);
        $this->comment($third, false);

        foreach (['posts.comments', 'posts.views'] as $route) {
            $this->get(route($route))->assertOk()
                ->assertViewHas('posts', fn ($posts) => array_column($posts->items(), 'id') === [$second->id, $first->id]);
        }
        $this->get(route('best.comments.paginate', 2))->assertOk()
            ->assertViewHas('posts', fn ($posts) => $posts->items()[0]['comments_count'] === 0);
    }

    public function test_monthly_comments_use_publication_month_and_refresh_after_moderation(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 27)->setTime(12, 0));
        $first = $this->createPost('first', ['date_published' => now()->startOfMonth()]);
        $second = $this->createPost('second', ['date_published' => now()]);
        $older = $this->createPost('older', ['date_published' => now()->startOfMonth()->subSecond()]);
        $next = $this->createPost('next', ['date_published' => now()->startOfMonth()->addMonth()]);
        $this->comment($first, true);
        $pending = $this->comment($second, false);
        $this->comment($older, true);
        $this->comment($next, true);

        $route = route('best.comments.month');
        $this->get($route)->assertOk()->assertViewHas('posts', fn ($posts) => array_column($posts, 'id') === [$first->id, $second->id]);
        app(CommentRepositoryInterface::class)->toggleVerification($pending);
        $this->get($route)->assertOk()->assertViewHas('posts', fn ($posts) => array_column($posts, 'id') === [$second->id, $first->id]);

        Comment::findOrFail($pending)->delete();
        $this->get($route)->assertOk()->assertViewHas('posts', fn ($posts) => array_column($posts, 'id') === [$first->id, $second->id]);
    }

    private function createPost(string $slug, array $attributes = []): Post
    {
        return Post::factory()->for($this->author)->create($attributes + [
            'slug' => $slug, 'date_published' => now(), 'updated_at' => now(),
        ]);
    }

    private function vote(Post $post, int $rating): void
    {
        DB::table('ratings')->insert(['post_id' => $post->id, 'user_id' => $this->author->id, 'rating' => $rating]);
    }

    private function comment(Post $post, bool $verified): int
    {
        return DB::table('comments')->insertGetId([
            'post_id' => $post->id, 'user_id' => $this->author->id,
            'message' => 'Comment', 'is_verified' => $verified, 'level' => 0,
        ]);
    }
}
