<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Legacy: `purchase` (+ line items captured in the PO form). Modelled here as
// a header (purchase_orders) plus child rows (purchase_order_items).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_no')->unique();
            $table->string('supplier')->nullable(); // legacy "Company"
            $table->date('order_date')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('payment_status')->default('unpaid');
            $table->timestamps();
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('inventory_id')->nullable()->constrained('inventory')->cascadeOnUpdate()->nullOnDelete();
            $table->string('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
    }
};
