<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Subject;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => Subject::factory(), // Tạo subject ngẫu nhiên trước khi liên kết
            'teacher_name' => $this->faker->name, // Tên ngẫu nhiên
            'day_of_birth' => $this->faker->optional()->date('Y-m-d', '-20 years'), // Ngày sinh ngẫu nhiên (cách đây ít nhất 20 năm)
            'gender' => $this->faker->randomElement(['male', 'female', 'other']), // Giới tính ngẫu nhiên
            'hometown' => $this->faker->optional()->city, // Quê quán ngẫu nhiên
            'phone_number' => $this->faker->optional()->phoneNumber, // Số điện thoại ngẫu nhiên
            'email' => $this->faker->unique()->safeEmail, // Email duy nhất
            'password' => bcrypt('password'), // Mật khẩu mã hóa
        ];
    }
}
