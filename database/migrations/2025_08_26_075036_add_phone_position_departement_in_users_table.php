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
            $table->enum('status_account', ['active', 'suspended'])->default('active')->after('id');
            $table->string('phone_number', '30')->after('password');
            $table->enum('position', ['Admin', 'Concept Art and Illustration', 'Web Programmer', '3D Artist'])->after('phone_number');
            $table->enum('department', ['Admin', 'Digital Art', 'IT', 'Animasi'])->after('position');
            $table->enum('role', ['admin', 'user'])->after('department');
            $table->integer('overwork_allowance')->after('role');
            $table->string('otp_reset_pass')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status_account', 'phone_number', 'position', 'department', 'role', 'overwork_allowance']);
        });
    }
};
