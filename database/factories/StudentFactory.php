<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Classes;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_name' => $this->faker->name, // Tên ngẫu nhiên
            'day_of_birth' => $this->faker->optional()->date('Y-m-d', '-18 years'), // Ngày sinh cách đây ít nhất 18 năm
            'gender' => $this->faker->randomElement(['male', 'female', 'other']), // Giới tính ngẫu nhiên
            'hometown' => $this->faker->optional()->city, // Quê quán ngẫu nhiên
            'phone_number' => $this->faker->optional()->phoneNumber, // Số điện thoại ngẫu nhiên
            'email' => $this->faker->unique()->safeEmail, // Email duy nhất
            'password' => bcrypt('password'), // Mật khẩu mã hóa
            'class_id' => Classes::factory(), // Liên kết với một lớp học ngẫu nhiê
        ];
    }
}
