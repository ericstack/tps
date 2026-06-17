<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_code' => fake()->unique()->bothify('PRD-####'),
            'product_name' => ucfirst(fake()->words(2, true)),
            'description' => fake()->sentence(5),
            'quantity' => fake()->numberBetween(0, 250),
        ];
    }
}
