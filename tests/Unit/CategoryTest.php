<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertOk();
    }

    public function test_create()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('categories.create'));

        $response->assertOk();
    }

    public function test_store()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Test Category',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }
    
    public function test_edit()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->get(route('categories.edit', ['id' => $category->id]));

        $response->assertOk();
    }

    public function test_update()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->patch(route('categories.update', ['id' => $category->id,]), [
            'name' => 'Updated Category',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    public function test_destroy()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete(route('categories.destroy', ['id' => $category->id]));

        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}