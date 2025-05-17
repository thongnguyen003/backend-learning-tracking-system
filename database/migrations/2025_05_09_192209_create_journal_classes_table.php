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
        Schema::create('journal_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id'); 
            $table->date('date'); 
            $table->text('topic'); 
            $table->text('description'); 
            $table->integer('assessment');
            $table->text('difficulty'); 
            $table->text('plan'); 
            $table->text('solution'); 
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_classes');
    }
};
