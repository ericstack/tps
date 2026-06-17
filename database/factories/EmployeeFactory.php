<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_code' => fake()->unique()->bothify('EMP-####'),
            'employee_name' => fake()->name(),
            'position' => fake()->randomElement(['Driver', 'Warehouse Staff', 'Manager', 'Clerk', 'Supervisor', 'Dispatcher']),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'birthday' => fake()->dateTimeBetween('-55 years', '-20 years')->format('Y-m-d'),
        ];
    }
}
