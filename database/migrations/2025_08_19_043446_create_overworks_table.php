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
        Schema::create('overworks', function (Blueprint $table) {
            $table->id();
            $table->date('overwork_date');
            $table->time('start_overwork');
            $table->time('finished_overwork');
            $table->text('task_description');
            $table->enum('request_status', ['draft', 'submitted', 'accepted', 'rejected']);

            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overworks');
    }
};
