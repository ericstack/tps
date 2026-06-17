<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_code' => fake()->unique()->bothify('ORD-#####'),
            'customer_id' => Customer::inRandomOrder()->value('id') ?? Customer::factory(),
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'address' => fake()->address(),
            'contact_number' => fake()->numerify('09#########'),
            'order_quantity' => fake()->numberBetween(1, 30),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'completed', 'cancelled']),
        ];
    }
}
