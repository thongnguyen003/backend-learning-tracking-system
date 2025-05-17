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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_goal_id')->nullable();
            $table->unsignedBigInteger('course_goal_id')->nullable();
            $table->unsignedBigInteger('journal_class_id')->nullable();
            $table->unsignedBigInteger('journal_self_id')->nullable();
            $table->timestamps();
            $table->foreign('journal_goal_id')->references('id')->on('journal_goals')->onDelete('set null');
            $table->foreign('course_goal_id')->references('id')->on('course_goals')->onDelete('set null');
            $table->foreign('journal_class_id')->references('id')->on('journal_classes')->onDelete('set null');
            $table->foreign('journal_self_id')->references('id')->on('journal_selfs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};
