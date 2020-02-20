<?php

namespace Tests\Feature;

use App\Repositories\CachedSeoRepository;
use App\Repositories\SeoRepository;
use App\Services\SeoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Seo;

class SeoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seo = factory(Seo::class, 3)->create();

        $this->seoService = new SeoService(new CachedSeoRepository(new SeoRepository()));
    }

    public function testGetAllData()
    {
        $result = $this->seoService->getAllData();

        $this->assertCount(3, $result);
    }
}
