<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('visit_date');
            $table->unique(['student_id', 'visit_date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_visits');
    }
};