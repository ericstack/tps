<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $assigned = fake()->dateTimeBetween('-30 days', 'now');

        return [
            'subject' => ucfirst(fake()->words(3, true)),
            'description' => fake()->sentence(8),
            'assigned_date' => $assigned->format('Y-m-d'),
            'due_date' => fake()->dateTimeBetween($assigned, '+30 days')->format('Y-m-d'),
            'employee_id' => Employee::inRandomOrder()->value('id') ?? Employee::factory(),
            'status' => fake()->randomElement([0, 1]),
        ];
    }
}
