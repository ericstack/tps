<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Legacy: `deliveries` (delivery_id, order_id, customer_name, address, employee_id, status).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('control_number')->unique();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('customer_name');
            $table->string('address')->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedTinyInteger('status')->default(0); // 0 = pending, 1 = delivered
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
