<?php

namespace Tests\Unit\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\PostService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    private PostRepositoryInterface $postRepository;
    private PostService $postService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->postRepository = $this->createMock(PostRepositoryInterface::class);
        $this->postService = new PostService($this->postRepository);
    }

    public function testGetTopPosts()
    {
        $limit = 5;
        $expectedPosts = array_fill(0, $limit, ['rating' => [], 'comments' => []]);

        $this->postRepository->expects($this->once())
            ->method('getTopPosts')
            ->with($limit)
            ->willReturn($expectedPosts);

        $result = $this->postService->getTopPosts($limit);

        $this->assertCount($limit, $result);
    }

    public function test_post_stats_count_boolean_and_legacy_verification_values(): void
    {
        $this->postRepository->expects($this->never())->method("getPostsCount");

        $post = [
            'rating' => [['rating' => 1], ['rating' => -1]],
            'comments' => array_map(
                fn ($value) => ['is_verified' => $value],
                [true, 1, '1', false, 0, '0']
            ),
        ];

        $result = $this->postService->calculatePostStats($post);

        $this->assertSame(1, $result['rating_count']);
        $this->assertSame(3, $result['comments_count']);
        $this->assertSame([$result], $this->postService->calculatePostStats([$post]));
    }

    public function testCalculateAndPaginate()
    {
        $posts = array_fill(0, 10, ['rating' => [], 'comments' => []]);
        $page = 1;

        $this->postRepository->expects($this->once())
            ->method('getPublishedPostsCount')
            ->willReturn(10);

        $result = $this->postService->calculateAndPaginate($posts, $page);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
