<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Auth accounts ---
        User::updateOrCreate(
            ['username' => 'test'],
            ['name' => 'Test Admin', 'password' => Hash::make('test'), 'access' => 1, 'active' => true],
        );
        User::updateOrCreate(
            ['username' => 'staff'],
            ['name' => 'Staff User', 'password' => Hash::make('password'), 'access' => 2, 'active' => true],
        );
        User::factory(6)->create();

        // --- Reference data ---
        Category::factory(8)->create();
        Product::factory(40)->create();
        Inventory::factory(60)->create();
        Customer::factory(35)->create();
        Employee::factory(20)->create();

        // --- Transactional data (depend on the above) ---
        Order::factory(50)->create();
        Task::factory(40)->create();
        TaskComment::factory(60)->create();

        // Link the demo `staff` login to an employee that actually has tasks,
        // so the assignee-only status/comment gating is testable out of the box.
        if ($assignedEmployeeId = Task::whereNotNull('employee_id')->value('employee_id')) {
            User::where('username', 'staff')->update(['employee_id' => $assignedEmployeeId]);
        }
        Delivery::factory(30)->create();

        PurchaseOrder::factory(25)->create()->each(function (PurchaseOrder $po) {
            $po->items()->saveMany(
                PurchaseOrderItem::factory(rand(1, 4))->make()
            );
        });

        // --- Activity log samples ---
        ActivityLog::factory()->count(15)->create();
    }
}
