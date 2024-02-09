<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_price' => $this->faker->randomFloat(2, 10, 100),
            'status' => $this->faker->randomElement(['processing', 'shipping', 'delivered', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['cash_on_delivery', 'card']),
            'payment_status' => $this->faker->randomElement(['pending', 'completed']),
        ];
    }
}
