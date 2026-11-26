<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Services\CategoryService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private Category $parent;
    private Category $child;
    private CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parent = Category::factory()->create([
            'name' => 'auto', 'displayname' => 'Автомобили', 'has_child' => true,
        ]);
        $this->child = Category::factory()->create([
            'name' => 'repair', 'displayname' => 'Ремонт', 'has_child' => false, 'parent_id' => $this->parent->id,
        ]);
        $this->service = app(CategoryService::class);
    }

    public function test_category_assignments_and_breadcrumbs_follow_the_parent_relationship(): void
    {
        $parent = $this->service->getPostCategory($this->parent->id);
        $child = $this->service->getCategoryByName('repair');
        $post = Post::factory()->create();
        $post->categories()->attach([$parent->id, $child->id]);

        $this->assertSame([$parent->id], $this->service->getPostAllCategoriesId($parent));
        $this->assertSame([$child->id, $parent->id], $this->service->getPostAllCategoriesId($child));
        $this->assertEqualsCanonicalizing([$parent->id, $child->id], $this->service->getPostCategoriesIdByPost($post->categories));
        $this->assertSame([
            ['name' => 'auto', 'displayname' => 'Автомобили'],
            ['name' => 'repair', 'displayname' => 'Ремонт'],
        ], $this->service->getCategoryNameWithParentName($child));
        $this->assertSame([$parent->id], $this->service->getAllParentCategories()->pluck('id')->all());
    }

    public function test_legacy_category_with_missing_parent_can_still_be_opened_and_assigned(): void
    {
        $this->child->update(['parent_id' => 50000]);
        $category = $this->service->getCategoryByName('repair');

        $this->assertSame([$this->child->id], $this->service->getPostAllCategoriesId($category));
        $this->get(route('category.show', 'repair'))->assertOk()
            ->assertViewHas('categories', [['name' => 'repair', 'displayname' => 'Ремонт']]);
        $this->get(route('category.show', 'unknown'))->assertNotFound();
        $this->getJson(route('category.paginate', ['unknown', 2]))->assertNotFound();
    }

    public function test_category_pagination_uses_consistent_counts_and_filters_in_html_and_json(): void
    {
        config(['pagination.postsPerPage' => 1]);
        $author = $this->userWithProfile();
        foreach (['first', 'second', 'archive', 'draft'] as $slug) {
            $post = Post::factory()->for($author)->create([
                'slug' => $slug,
                'date_published' => now(),
                'is_published' => $slug !== 'draft',
                'archived_at' => $slug === 'archive' ? now() : null,
            ]);
            $post->categories()->attach($this->child->id);
        }

        $pageTwo = route('category.paginate', ['repair', 2]);
        $this->get(route('category.show', 'repair'))->assertOk()->assertSee($pageTwo)
            ->assertViewHas('lastNumberPage', 2)->assertSee(route('category.show', 'auto'));
        $this->get($pageTwo)->assertOk()->assertViewHas('posts', fn ($posts) => $posts->items()[0]['slug'] === 'first');
        $this->getJson(route('category.paginate', ['repair', 1]))->assertOk()->assertJsonPath('posts.0.slug', 'second');
        $this->getJson($pageTwo)->assertOk()
            ->assertJsonPath('posts.0.slug', 'first')
            ->assertJsonPath('posts.0.pivot.category_id', $this->child->id)
            ->assertJsonPath('pagination.last', 2)
            ->assertJsonPath('pagination.current', 2);
    }

    public function test_post_forms_offer_child_categories_and_keep_the_child_selected_when_editing(): void
    {
        (new \SeoTableSeeder())->run();
        $author = $this->userWithProfile();
        $author->assignRole(Role::findOrCreate('admin', 'web'));
        $post = Post::factory()->for($author)->create();
        $post->categories()->attach([$this->parent->id, $this->child->id]);

        $this->actingAs($author)->get(route('admin.posts.create'))->assertOk()
            ->assertViewHas('categories', fn ($categories) => $categories->pluck('id')->all() === [$this->parent->id, $this->child->id]);
        $this->get(route('admin.posts.edit', $post->id))->assertOk()
            ->assertViewHas('selectedCategoryId', $this->child->id)
            ->assertSee('value="'.$this->child->id.'" selected', false);

        $data = [
            'title' => 'Updated', 'description' => 'Description', 'name' => 'Name',
            'caption' => 'Caption', 'body' => 'Body', 'image' => 'https://example.test/image.jpg',
        ];
        $this->post(route('admin.posts.store'), $data + ['category' => $this->child->id, 'slug' => 'new-repair'])
            ->assertRedirect(route('admin.posts'));
        $this->assertEqualsCanonicalizing(
            [$this->parent->id, $this->child->id],
            Post::where('slug', 'new-repair')->sole()->categories()->pluck('categories.id')->all()
        );

        $route = route('admin.posts.update', $post->id);
        $this->putJson($route, $data + ['category' => 50000])->assertUnprocessable()
            ->assertJsonValidationErrors('category');
        $this->put($route, $data + ['category' => $this->child->id])->assertRedirect();
        $this->assertEqualsCanonicalizing(
            [$this->parent->id, $this->child->id],
            $post->categories()->pluck('categories.id')->all()
        );
    }

    private function userWithProfile(): User
    {
        $user = User::factory()->create(['username' => 'category-author', 'email_verified_at' => now()]);
        DB::table('profiles')->insert(['user_id' => $user->id, 'avatar' => '/avatar.png', 'public' => true]);

        return $user;
    }
}
