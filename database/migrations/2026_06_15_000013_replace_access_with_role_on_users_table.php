<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Replaces the legacy integer `access` (1=admin, 2=user) with named roles
// (config/roles.php) and adds a forced-password-change flag. Also enforces
// one login per employee via a unique index on employee_id.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->after('password');
            $table->boolean('must_change_password')->default(false)->after('active');
        });

        // Backfill roles from the old access tiers before dropping the column.
        DB::table('users')->where('access', 1)->update(['role' => 'admin']);
        DB::table('users')->where('access', 2)->update(['role' => 'staff']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('access');
            // One employee = one login (nullable: many accounts may be unlinked).
            $table->unique('employee_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['employee_id']);
            $table->unsignedTinyInteger('access')->default(2)->after('password');
        });

        DB::table('users')->where('role', 'admin')->update(['access' => 1]);
        DB::table('users')->where('role', '!=', 'admin')->update(['access' => 2]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'must_change_password']);
        });
    }
};
