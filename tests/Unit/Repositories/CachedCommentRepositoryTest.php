<?php

namespace Tests\Unit\Repositories;

use App\DTO\CommentUpdateDTO;
use App\Repositories\CachedCommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CachedCommentRepositoryTest extends TestCase
{
    private CommentRepositoryInterface $commentRepository;
    private CachedCommentRepository $cachedRepository;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->commentRepository = $this->createMock(CommentRepositoryInterface::class);
        $this->cachedRepository = new CachedCommentRepository($this->commentRepository);
    }

    public function testGetByIdUsesCache()
    {
        $this->commentRepository->expects($this->never())->method("getById");

        $commentId = 1;
        $expectedComment = ['id' => $commentId, 'message' => 'Test'];
        
        Cache::shouldReceive('remember')
            ->once()
            ->with("comment_{$commentId}", 3600, \Mockery::type(\Closure::class))
            ->andReturn($expectedComment);

        $result = $this->cachedRepository->getById($commentId);

        $this->assertEquals($expectedComment, $result);
    }

    public function test_update_invalidates_both_threads_after_writing(): void
    {
        $comment = new CommentUpdateDTO(1, 1, 2, 'Test', 0);
        $keys = [
            'comment_1', 'comments_verified_count', 'comments_unverified_count',
            'unverified_comments', 'comment_exists_1', 'comments_for_post_1', 'comments_for_post_2',
        ];
        foreach ($keys as $key) {
            Cache::put($key, 'stale', 60);
        }

        $this->commentRepository->expects($this->once())
            ->method('getPostIdsForComments')->with([1])->willReturn([1]);
        $this->commentRepository->expects($this->once())
            ->method('update')->with($comment)
            ->willReturnCallback(function (): void {
                $this->assertSame('stale', Cache::get('comment_1'));
            });

        $this->cachedRepository->update($comment);

        foreach ($keys as $key) {
            $this->assertNull(Cache::get($key), $key);
        }
    }

    public function test_bulk_verification_invalidates_affected_threads_and_counters(): void
    {
        Cache::put('comments_for_post_1', [], 60);
        Cache::put('comments_for_post_2', [], 60);
        Cache::put('comments_for_post_3', [], 60);
        Cache::put('comments_verified_count', 0, 60);

        $this->commentRepository->expects($this->once())
            ->method('getPostIdsForComments')->with([10, 20, 99])->willReturn([1, 2]);
        $this->commentRepository->expects($this->once())
            ->method('bulkVerify')->with([10, 20, 99])->willReturn(2);

        $this->assertSame(2, $this->cachedRepository->bulkVerify([10, 20, 99]));

        $this->assertNull(Cache::get('comments_for_post_1'));
        $this->assertNull(Cache::get('comments_for_post_2'));
        $this->assertSame([], Cache::get('comments_for_post_3'));
        $this->assertNull(Cache::get('comments_verified_count'));
    }
}
