<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DetailMessage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Message;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailMessage>
 */
class DetailMessageFactory extends Factory
{
    protected $model = DetailMessage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message_id' => Message::factory(),
            'student_id' => Student::factory(),
            'teacher_id' => Teacher::factory(),
            'content' => $this->faker->paragraph(3),
            'time' => now(),
        ];
    }
}
