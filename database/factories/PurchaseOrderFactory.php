<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'po_no' => fake()->unique()->bothify('PO-#####'),
            'supplier' => fake()->company(),
            'order_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'total' => fake()->randomFloat(2, 100, 50000),
            'payment_status' => fake()->randomElement(['unpaid', 'partial', 'paid']),
        ];
    }
}
