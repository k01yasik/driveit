<?php

namespace Tests\Unit\Http\Controllers;

use App\Services\CommentService;
use App\Services\PostService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    public function testShowPost()
    {
        $postService = $this->createMock(PostService::class);
        $commentService = $this->createMock(CommentService::class);
        $seoService = $this->createMock(SeoService::class);

        $postSlug = 'test-post';
        $expectedPost = ['id' => 1, 'title' => 'Test Post'];
        $expectedComments = [['id' => 1, 'message' => 'Test comment']];

        $postService->expects($this->once())
            ->method('getPostWithStats')
            ->with($postSlug)
            ->willReturn($expectedPost);

        $commentService->expects($this->once())
            ->method('getNestedComments')
            ->with($expectedPost['id'])
            ->willReturn($expectedComments);

        $controller = new PageController(
            $seoService,
            $commentService,
            /* другие зависимости... */
        );

        $response = $controller->show($postSlug);

        $this->assertEquals('posts.show', $response->name());
        $this->assertArrayHasKey('post', $response->getData());
        $this->assertArrayHasKey('sortedComments', $response->getData());
    }
}
