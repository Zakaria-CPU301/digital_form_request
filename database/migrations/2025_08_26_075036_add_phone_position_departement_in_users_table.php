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
            $table->string('phone_number', '30')->after('password');
            $table->enum('position', ['Admin', 'Concept Art and Illustration', 'Web Programmer', '3D Artist'])->after('phone_number');
            $table->enum('departement', ['Admin', 'Digital Art', 'IT', 'Animasi'])->after('position');
            $table->enum('role', ['admin', 'user'])->after('departement');
            $table->integer('overwork_allowance')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'position', 'departement', 'role', 'overwork_allowance']);
        });
    }
};
