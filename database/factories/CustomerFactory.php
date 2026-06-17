<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_code' => fake()->unique()->bothify('CUST-####'),
            'name' => fake()->name(),
            'address' => fake()->address(),
            'contact_number' => fake()->numerify('09#########'),
        ];
    }
}
