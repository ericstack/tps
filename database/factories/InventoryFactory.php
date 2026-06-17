<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'serial_no' => fake()->unique()->numerify('##-###-####'),
            'name' => ucfirst(fake()->words(2, true)),
            'description' => fake()->sentence(4),
            'quantity' => fake()->numberBetween(0, 100),
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }
}
