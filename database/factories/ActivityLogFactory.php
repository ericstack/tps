<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['Login', 'Order', 'Inventory', 'System']),
            'msg' => fake()->sentence(6),
        ];
    }
}
