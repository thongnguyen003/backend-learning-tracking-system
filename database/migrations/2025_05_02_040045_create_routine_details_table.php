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
        Schema::create('routine_details', function (Blueprint $table) {
            $table->id();
            $table->String('title',50);
            $table->String('description', 225);
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->unsignedBigInteger('routine_id');
            $table->foreign('routine_id')->references('id')->on('routines')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_details');
    }
};
