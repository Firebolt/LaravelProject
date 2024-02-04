<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_valid()
    {
        $response = $this->get(route('products.index'));
        $response->assertOk();

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertOk();

        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertOk();
    }

    public function test_show_valid()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('products.show', $product->id));
        $response->assertOk();

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('products.show', $product->id));
        $response->assertOk();

        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('products.show', $product->id));
        $response->assertOk();
    }

    public function test_show_not_found()
    {
        $response = $this->get(route('products.show', 1));
        $response->assertNotFound();

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('products.show', 1));
        $response->assertNotFound();

        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('products.show', 1));
        $response->assertNotFound();
    }

    public function test_create_not_authorized()
    {
        $response = $this->get(route('products.create'));
        $response->assertRedirect('/login');

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('products.create'));
        $response->assertRedirect('/');
    }

    public function test_create_valid()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('products.create'));
        $response->assertOk();
    }

    public function test_store_not_authorized()
    {
        $category = Category::factory()->create();
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $category = Category::factory()->create();
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    public function test_store_valid()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_store_validation()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => '',
            'description' => '',
            'price' => '',
            'stock_quantity' => '',
            'category_id' => '',
        ]);
        $response->assertSessionHasErrors(['name', 'description', 'price', 'stock_quantity', 'category_id']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 'not a number',
            'stock_quantity' => 'not a number',
            'category_id' => 'not a number',
        ]);
        $response->assertSessionHasErrors(['price', 'stock_quantity', 'category_id']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => 99999,
        ]);
        $response->assertSessionHasErrors(['category_id']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $category = Category::factory()->create();
        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertSessionHasErrors(['price']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    public function test_edit_not_authorized()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('products.edit', $product->id));
        $response->assertRedirect('/login');

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('products.edit', $product->id));
        $response->assertRedirect('/');
    }

    public function test_edit_no_product()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('products.edit', 1));
        $response->assertNotFound();

        $response = $this->actingAs($user)->get(route('products.edit', 'not-a-number'));
        $response->assertNotFound();
    }

    public function test_edit_valid()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('products.edit', $product->id));
        $response->assertOk();
    }

    public function test_update_not_authorized()
    {
        $product = Product::factory()->create();
        $response = $this->patch(route('products.update', $product->id), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $product->category_id,
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->patch(route('products.update', $product->id), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $product->category_id,
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    public function test_update_validation()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();
        $response = $this->actingAs($user)->patch(route('products.update', $product->id), [
            'name' => '',
            'description' => '',
            'price' => '',
            'stock_quantity' => '',
            'category_id' => '',
        ]);
        $response->assertSessionHasErrors(['name', 'description', 'price', 'stock_quantity', 'category_id']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $response = $this->actingAs($user)->patch(route('products.update', $product->id), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 'not a number',
            'stock_quantity' => 'not a number',
            'category_id' => 'not a number',
        ]);
        $response->assertSessionHasErrors(['price', 'stock_quantity', 'category_id']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $response = $this->actingAs($user)->patch(route('products.update', $product->id), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => 99999,
        ]);
        $response->assertSessionHasErrors(['category_id']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $category = Category::factory()->create();
        $response = $this->actingAs($user)->patch(route('products.update', $product->id), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertSessionHasErrors(['price']);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    public function test_update_no_product()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->patch(route('products.update', 1), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);

        $response = $this->actingAs($user)->patch(route('products.update', 'not-a-number'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    public function test_update_valid()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->patch(route('products.update', $product->id), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.00,
            'stock_quantity' => 10,
            'category_id' => $product->category_id,
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_delete_not_authorized()
    {
        $product = Product::factory()->create();
        $response = $this->delete(route('products.destroy', $product->id));
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('products', ['name' => $product->name]);

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->delete(route('products.destroy', $product->id));
        $response->assertRedirect('/');
        $this->assertDatabaseHas('products', ['name' => $product->name]);
    }

    public function test_delete_no_product()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->delete(route('products.destroy', 9999));
        $response->assertNotFound();
        $this->assertDatabaseHas('products', ['name' => $product->name]);

        $response = $this->actingAs($user)->delete(route('products.destroy', 'not-a-number'));
        $response->assertNotFound();
        $this->assertDatabaseHas('products', ['name' => $product->name]);
    }

    public function test_delete_valid()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->delete(route('products.destroy', $product->id));
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
    }
}
