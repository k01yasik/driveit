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

    public function testUpdateClearsCache()
    {
        $comment = new CommentUpdateDTO(1, 1, 1, 'Test', 0);
        
        Cache::shouldReceive('forget')
            ->once()
            ->with("comment_1");
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('comments_verified_count');
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('comments_unverified_count');
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('unverified_comments');

        Cache::shouldReceive('forget')->once()->with('comment_exists_1');
        Cache::shouldReceive('forget')->once()->with('parent_valid_1_*');

        $this->commentRepository->expects($this->once())
            ->method('update')
            ->with($comment);

        $this->cachedRepository->update($comment);
    }
}
