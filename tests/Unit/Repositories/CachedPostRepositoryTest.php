<?php

namespace Tests\Unit\Repositories;

use App\Observers\PostObserver;
use App\Repositories\CachedPostRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Tests\TestCase;

class CachedPostRepositoryTest extends TestCase
{
    public function test_listing_cache_varies_by_limit_and_is_invalidated_on_post_save(): void
    {
        $inner = $this->createMock(PostRepositoryInterface::class);
        $inner->expects($this->exactly(3))->method('getTopPosts')
            ->willReturnCallback(fn (int $count): array => array_fill(0, $count, []));
        $inner->expects($this->exactly(3))->method('getPostsForPage')
            ->willReturnCallback(fn (int $page, int $count): array => array_fill(0, $count, []));
        $repository = new CachedPostRepository($inner);

        $this->assertCount(2, $repository->getTopPosts(2));
        $this->assertCount(3, $repository->getTopPosts(3));
        $this->assertCount(2, $repository->getTopPosts(2));
        $this->assertCount(2, $repository->getPostsForPage(1, 2));
        $this->assertCount(3, $repository->getPostsForPage(1, 3));
        $this->assertCount(2, $repository->getPostsForPage(1, 2));

        (new PostObserver())->saved();

        $this->assertCount(2, $repository->getTopPosts(2));
        $this->assertCount(2, $repository->getPostsForPage(1, 2));
    }
}
