<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('email')->constrained()->onDelete('set null');
            $table->string('employee_id')->unique()->after('name');
            $table->enum('role', ['employee', 'manager', 'admin'])->default('employee')->after('department_id');
            $table->integer('annual_leave_days')->default(30)->after('role');
            $table->integer('sick_leave_days')->default(15)->after('annual_leave_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['department_id', 'employee_id', 'role', 'annual_leave_days', 'sick_leave_days']);
        });
    }
};
