<?php

namespace Tests\Unit\Services;

use App\DTO\CommentDTO;
use App\DTO\CommentStoreResultDTO;
use App\Models\Comment;
use App\Models\User;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    private CommentRepositoryInterface $commentRepository;
    private CommentService $commentService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->commentRepository = $this->createMock(CommentRepositoryInterface::class);
        $this->commentService = new CommentService($this->commentRepository);
    }

    public function testStoreComment()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('user')->once()->andReturn($user);
        Auth::shouldReceive('id')->once()->andReturn($user->id);

        $commentDTO = new CommentDTO(
            postId: 1,
            message: 'Test message',
            level: 1,
            parentId: null
        );

        $expectedData = [
            'user_id' => $user->id,
            'post_id' => 1,
            'message' => 'Test message',
            'is_verified' => false,
            'level' => 1,
            'parent_id' => null
        ];

        $this->commentRepository->expects($this->once())
            ->method('create')
            ->with($expectedData)
            ->willReturn(Comment::factory()->make()->toArray());

        $result = $this->commentService->store($commentDTO);

        $this->assertInstanceOf(CommentStoreResultDTO::class, $result);
    }

    public function testGetNestedComments()
    {
        $postId = 1;
        $comments = [
            ['id' => 1, 'parent_id' => null, 'level' => 0],
            ['id' => 2, 'parent_id' => 1, 'level' => 1]
        ];

        $this->commentRepository->expects($this->once())
            ->method('getByPostId')
            ->with($postId)
            ->willReturn($comments);

        $result = $this->commentService->getNestedComments($postId);

        $this->assertIsArray($result);
        $this->assertCount(1, $result); // Only root comments
        $this->assertCount(1, $result[0]['children']); // Nested comment
    }
}
