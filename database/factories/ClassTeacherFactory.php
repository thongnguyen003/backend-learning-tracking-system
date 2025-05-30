<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClassTeacher;
use App\Models\Teacher;
use App\Models\Classes;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClassTeacherFactory extends Factory
{
    protected $model = ClassTeacher::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(), // Tạo một giáo viên ngẫu nhiên
            'classes_id' => Classes::factory(),  // Tạo một lớp học ngẫu nhiên
        ];
    }
}
