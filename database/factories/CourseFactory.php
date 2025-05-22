<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Classes;
use App\Models\Teacher;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDay = $this->faker->dateTimeBetween('now', '+1 month'); 
        $endDay = $this->faker->dateTimeBetween($startDay, '+3 months'); 
        return [
            'course_name' => $this->faker->sentence(3), // Tên khóa học ngẫu nhiên
            'start_day' => $startDay, // Ngày bắt đầu ngẫu nhiên
            'end_day' => $endDay, // Ngày kết thúc ngẫu nhiên sau ngày bắt đầu
            'status' => $this->faker->numberBetween(0, 1), // Trạng thái (giả định: 0 = inactive, 1 = active)
            'next_deadline' => $this->faker->time('H:i:s'),
            'next_date' => $this->faker->optional()->date(),
            'accept_deadline' => $this->faker->optional()->word(),
            'type_process' => $this->faker->optional()->randomElement(['1week', '2week']),
            'has_deadline' => $this->faker->boolean(),
            'class_id' => Classes::factory(), // Liên kết ngẫu nhiên với một lớp học
            'teacher_id' => Teacher::factory(), // Liên kết ngẫu nhiên với một giáo viên
        ];
    }
}
