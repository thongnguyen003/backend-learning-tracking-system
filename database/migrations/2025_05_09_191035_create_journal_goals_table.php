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
        Schema::create('journal_goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id'); 
            $table->text('title')->nullable(); 
            $table->integer('state')->default(1); 
            $table->dateTime('date');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_goals');
    }
};
