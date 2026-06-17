<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'inventory_id' => Inventory::inRandomOrder()->value('id'),
            'description' => ucfirst(fake()->words(2, true)),
            'quantity' => fake()->numberBetween(1, 50),
        ];
    }
}
