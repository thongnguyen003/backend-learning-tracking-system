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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 50); 
            $table->date('day_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('hometown', 255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('email', 255); 
            $table->text('password'); 
            $table->unsignedBigInteger('class_id'); 
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
