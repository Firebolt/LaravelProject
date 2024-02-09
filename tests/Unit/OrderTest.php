<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('orders.index'));
        $response->assertOk();

        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('orders.index'));
        $response->assertOk();
    }

    public function test_index_not_authorized()
    {
        $response = $this->get(route('orders.index'));
        $response->assertRedirect('/login');
    }

    public function test_store()
    {
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create([
            'stock_quantity' => 50,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 50,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 5,
            'payment_method' => 'cash_on_delivery',
        ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'cash_on_delivery',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create([
            'stock_quantity' => 50,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 50,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 5,
            'payment_method' => 'card',
        ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'card',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);
    }

    public function test_store_as_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create([
            'stock_quantity' => 50,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 50,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 5,
            'payment_method' => 'cash_on_delivery',
        ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'cash_on_delivery',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $user = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create([
            'stock_quantity' => 50,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 50,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 5,
            'payment_method' => 'card',
        ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'card',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);
    }

    public function test_store_out_of_stock()
    {
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create([
            'stock_quantity' => 5,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 5,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 10,
            'payment_method' => 'cash_on_delivery',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['stock']);

        $user = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create([
            'stock_quantity' => 5,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 5,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 10,
            'payment_method' => 'cash_on_delivery',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['stock']);
    }

    public function test_store_not_authorized()
    {
        $response = $this->post(route('orders.store'));
        $response->assertRedirect('/login');
    }

    public function test_store_validate()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->post(route('orders.store'));
        $response->assertSessionHasErrors(['payment_method', 'product_id', 'quantity']);

        $product = Product::factory()->create();
        $response = $this->actingAs($user)->post(route('orders.store'), [
            'payment_method' => 'invalid',
            'product_id' => $product->id,
            'quantity' => 0,
        ]);
        $response->assertSessionHasErrors(['payment_method', 'quantity']);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'payment_method' => 'cash_on_delivery',
            'product_id' => 999,
            'quantity' => 0,
        ]);
        $response->assertSessionHasErrors(['product_id', 'quantity']);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'payment_method' => 'cash_on_delivery',
            'product_id' => $product->id,
            'quantity' => -1,
        ]);
        $response->assertSessionHasErrors(['quantity']);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'payment_method' => 'cash_on_delivery',
            'product_id' => $product->id,
            'quantity' => 0,
        ]);
        $response->assertSessionHasErrors(['quantity']);
    }

    public function test_show()
    {
        $user = User::factory()->create(['role' => 'user']);
        $order = Order::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->get(route('orders.show', $order->id));
        $response->assertOk();

        $user = User::factory()->create(['role' => 'admin']);
        $order = Order::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->get(route('orders.show', $order->id));
        $response->assertOk();
    }

    public function test_show_not_authorized()
    {
        $order = Order::factory()->create();
        $response = $this->get(route('orders.show', $order->id));
        $response->assertRedirect('/login');
    }

    public function test_show_not_found()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('orders.show', 9999));
        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHasErrors(['order']);

        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('orders.show', 9999));
        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHasErrors(['order']);
    }
}
