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
        Schema::create('journal_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id'); // FK course_id
            $table->date('start_date');
            $table->date('end_date');
            $table->time('deadline')->nullable(); 
            $table->string('accept_deadline', 20)->nullable();
            $table->integer('status'); 
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_times');
    }
};
