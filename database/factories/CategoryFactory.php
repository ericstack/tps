<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Transportation', 'Technology', 'A.I', 'Finance', 'Health Care',
                'Consumer Services', 'Capital Goods', 'Energy', 'Retail', 'Logistics',
            ]),
            'description' => fake()->bs(),
        ];
    }
}
