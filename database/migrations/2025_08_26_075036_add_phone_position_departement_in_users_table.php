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
            $table->enum('position', ['a', 'b', 'c', 'd'])->after('phone_number');
            $table->enum('departement', ['a', 'b', 'c', 'd'])->after('position');
            $table->enum('roles', ['admin', 'user'])->after('departement');
            $table->integer('overwork_allowance')->after('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'position', 'departement', 'roles', 'overwork_allowance']);
        });
    }
};
