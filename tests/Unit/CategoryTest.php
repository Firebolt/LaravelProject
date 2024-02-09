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

    public function test_create_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('categories.create'));

        $response->assertRedirect('/');
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

    public function test_store_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Test Category',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('categories', ['name' => 'Test Category']);
    }

    public function test_store_validate()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => null,
        ]);

        $response->assertSessionHasErrors('name');
    }
    
    public function test_edit()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->get(route('categories.edit', ['id' => $category->id]));

        $response->assertOk();
    }

    public function test_edit_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->get(route('categories.edit', ['id' => $category->id]));

        $response->assertRedirect('/');
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

    public function test_update_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->patch(route('categories.update', ['id' => $category->id,]), [
            'name' => 'Updated Category',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('categories', ['name' => 'Updated Category']);
    }

    public function test_update_validate()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->patch(route('categories.update', ['id' => $category->id,]), [
            'name' => null,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_update_not_found()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->patch(route('categories.update', ['id' => 1]), [
            'name' => 'Updated Category',
        ]);

        $response->assertRedirect('/categories');
    }

    public function test_destroy()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete(route('categories.destroy', ['id' => $category->id]));

        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_destroy_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete(route('categories.destroy', ['id' => $category->id]));

        $response->assertRedirect('/');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_destroy_not_found()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->delete(route('categories.destroy', ['id' => 1]));

        $response->assertRedirect('/categories');
    }
}