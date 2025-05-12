<?php

namespace Tests\Unit\Repositories;

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
        
        Cache::shouldReceive('remember')->zeroOrMoreTimes();
        Cache::shouldReceive('forget')->zeroOrMoreTimes();
    }

    public function testGetByIdUsesCache()
    {
        $commentId = 1;
        $expectedComment = ['id' => $commentId, 'message' => 'Test'];
        
        Cache::shouldReceive('remember')
            ->once()
            ->with("comment_{$commentId}", 3600, \Closure::class)
            ->andReturn($expectedComment);

        $result = $this->cachedRepository->getById($commentId);

        $this->assertEquals($expectedComment, $result);
    }

    public function testUpdateClearsCache()
    {
        $comment = ['id' => 1];
        
        Cache::shouldReceive('forget')
            ->once()
            ->with("comment_1");
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('comments_verified_count');
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('comments_not_verified_count');
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('unpublished_comments');

        $this->commentRepository->expects($this->once())
            ->method('update')
            ->with($comment);

        $this->cachedRepository->update($comment);
    }
}
