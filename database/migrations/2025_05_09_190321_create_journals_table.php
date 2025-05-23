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
        Schema::create('journals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('course_student_id');
        $table->date('start_day'); 
        $table->date('end_day'); 
        $table->dateTime('open_date'); 
        $table->dateTime('deadline'); 
        $table->timestamps();
        $table->foreign('course_student_id')->references('id')->on('course_students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
