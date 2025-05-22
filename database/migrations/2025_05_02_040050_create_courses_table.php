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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name', 255);
            $table->date('start_day'); 
            $table->date('end_day'); 
            $table->integer('status')->default(1);
            $table->time('next_deadline')->nullable()->default('23:59:59');
            $table->date('next_date')->nullable(); 
            $table->string('accept_deadline', 20)->nullable();
            $table->string('type_process', 10)->nullable(); 
            $table->boolean('has_deadline')->default(false);
            $table->unsignedBigInteger('class_id'); 
            $table->unsignedBigInteger('teacher_id'); 
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
