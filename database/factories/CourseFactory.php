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
            'default_deadline' => '23:59:59', // Giá trị mặc định
            'course_deadline' => $this->faker->optional()->dateTimeBetween($startDay, $endDay), // Deadline ngẫu nhiên hoặc null
            'class_id' => Classes::factory(), // Liên kết ngẫu nhiên với một lớp học
            'teacher_id' => Teacher::factory(), // Liên kết ngẫu nhiên với một giáo viên
        ];
    }
}
