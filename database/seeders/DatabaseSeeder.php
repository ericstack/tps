<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account (legacy `accounts` seed: username "test").
        User::updateOrCreate(
            ['username' => 'test'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('test'),
                'access' => 1,
                'active' => true,
            ]
        );

        $categories = [
            ['name' => 'Transportation', 'description' => 'Oil Refining/Marketing'],
            ['name' => 'Technology', 'description' => 'Computer peripheral equipment'],
            ['name' => 'A.I', 'description' => 'EDP Services'],
            ['name' => 'Finance', 'description' => 'Major Banks'],
            ['name' => 'Health Care', 'description' => 'Major Pharmaceuticals'],
            ['name' => 'Consumer Services', 'description' => 'Hotels/Resorts'],
            ['name' => 'Capital Goods', 'description' => 'Industrial Machinery/Components'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
