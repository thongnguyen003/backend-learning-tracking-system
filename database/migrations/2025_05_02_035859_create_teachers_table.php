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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id'); 
            $table->string('teacher_name', 50); 
            $table->date('day_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('hometown', 255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('email', 255); 
            $table->text('password'); 
            $table->timestamps();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
