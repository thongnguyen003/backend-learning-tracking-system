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
        Schema::create('archievement_images', function (Blueprint $table) {
            $table->id();
            $table->String('link',225);
            $table->unsignedBigInteger('archievement_id');
            $table->foreign('archievement_id')->references('id')->on('archievements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archievement_images');
    }
};
