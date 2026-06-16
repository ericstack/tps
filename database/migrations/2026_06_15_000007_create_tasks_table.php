<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Legacy: `task` (task_id, subject, description, assigned, due, employee_id, status).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->date('assigned_date')->nullable(); // legacy `assigned`
            $table->date('due_date')->nullable();       // legacy `due`
            $table->foreignId('employee_id')->nullable()->constrained('employees')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedTinyInteger('status')->default(0); // 0 = open, 1 = done
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
