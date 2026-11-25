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

    public function testCalculateAndPaginate()
    {
        $posts = array_fill(0, 10, ['rating' => [], 'comments' => []]);
        $page = 1;

        $this->postRepository->expects($this->once())
            ->method('getPostsCount')
            ->willReturn(10);

        $result = $this->postService->calculateAndPaginate($posts, $page);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
