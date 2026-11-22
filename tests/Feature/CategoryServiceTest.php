<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private Category $parent_category;
    private Category $child_category;
    private CategoryService $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->parent_category = Category::class::factory()->create([
           'has_child' => true,
        ]);

        $this->child_category = Category::class::factory()->create([
           'has_child' => false,
           'parent_id' => $this->parent_category->id,
        ]);

        $post = Post::factory()->create();
        $post->categories()->attach([$this->parent_category->id, $this->child_category->id]);

        $this->categoryService = new CategoryService(new CategoryRepository());
    }

    public function testReturnAllCategoryIdsIfChild()
    {
        $allCategoryIds = $this->categoryService->getPostAllCategoriesId($this->categoryService->getPostCategory($this->child_category->id));

        $this->assertIsArray($allCategoryIds);

        $this->assertCount(2, $allCategoryIds);

        $this->assertEquals($this->child_category->id, $allCategoryIds[0]);

        $this->assertEquals($this->parent_category->id, $allCategoryIds[1]);
    }

    public function testReturnAllCategoryIdsIfParent()
    {
        $allCategoryIds = $this->categoryService->getPostAllCategoriesId($this->categoryService->getPostCategory($this->parent_category->id));

        $this->assertIsArray($allCategoryIds);

        $this->assertCount(1, $allCategoryIds);

        $this->assertEquals($this->parent_category->id, $allCategoryIds[0]);
    }

    public function testReterningAllCategoriesIdsByPost()
    {
        $test_post = Post::with('categories')->first();

        $return = $this->categoryService->getPostCategoriesIdByPost($test_post->categories);

        $this->assertIsArray($return);

        $this->assertCount(2, $return);

        $this->assertContains($this->parent_category->id, $return);

        $this->assertContains($this->child_category->id, $return);
    }

    public function testReturnRightsCategoryName()
    {
        $data = $this->categoryService->getCategoryNameWithParentName($this->categoryService->getPostCategory($this->child_category->id));

        $this->assertIsArray($data);

        $this->assertCount(2, $data);

        $this->assertEquals($this->parent_category->name, $data[0]['name']);

        $this->assertEquals($this->child_category->displayname, $data[1]['displayname']);
    }
}
