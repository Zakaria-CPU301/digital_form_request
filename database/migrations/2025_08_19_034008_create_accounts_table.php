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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email', 100);
            $table->string('phone_number', '30');
            $table->enum('position', ['a', 'b', 'c', 'd']);
            $table->enum('departement', ['a', 'b', 'c', 'd']);
            $table->enum('roles', ['admin', 'user']);
            $table->integer('overwork_allowance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
