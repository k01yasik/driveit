<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use App\Seo;

class SeoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seo = factory(Seo::class)->create();
    }

    public function testAddTitleToPage()
    {
        $response = $this->get('/');

        $response->assertSee($this->seo->title);
    }

    public function testAddingDescriptionToPage()
    {
        $response = $this->get('/');

        $response->assertSee($this->seo->description);
    }

    public function testModelNotFoundExceptionWhenRouteNameNotAdedToSeoTable()
    {
        $response = $this->get(route('posts.index'));
        $this->assertEquals(get_class($response->exception), 'Illuminate\Database\Eloquent\ModelNotFoundException');
    }
}
