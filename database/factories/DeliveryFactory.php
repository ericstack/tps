<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'control_number' => fake()->unique()->bothify('DCN-######'),
            'order_id' => Order::inRandomOrder()->value('id') ?? Order::factory(),
            'customer_name' => fake()->name(),
            'address' => fake()->address(),
            'employee_id' => Employee::inRandomOrder()->value('id') ?? Employee::factory(),
            'status' => fake()->randomElement(['pending', 'in transit', 'delivered', 'failed']),
        ];
    }
}
