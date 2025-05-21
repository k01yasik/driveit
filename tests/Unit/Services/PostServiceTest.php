<?php

namespace Tests\Unit\Services;

use App\Models\Post;
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
        $expectedPosts = Post::factory()->count($limit)->make();

        $this->postRepository->expects($this->once())
            ->method('getTopPosts')
            ->with($limit)
            ->willReturn($expectedPosts);

        $result = $this->postService->getTopPosts($limit);

        $this->assertCount($limit, $result);
    }

    public function testCalculateAndPaginate()
    {
        $posts = Post::factory()->count(10)->make();
        $page = 1;

        $this->postRepository->expects($this->once())
            ->method('calculatePostStats')
            ->with($posts)
            ->willReturn($posts);

        $this->postRepository->expects($this->once())
            ->method('getPostsPaginator')
            ->with($posts, $page, config('pagination.postsPerPage'))
            ->willReturn(new LengthAwarePaginator($posts, 10, config('pagination.postsPerPage')));

        $result = $this->postService->calculateAndPaginate($posts, $page);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
