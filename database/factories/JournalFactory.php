<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Journal;
use App\Models\CourseStudent;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{
    protected $model = Journal::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_student_id' => CourseStudent::factory(),
            'start_day' => $this->faker->date(),
            'end_day' => $this->faker->date(),
            'open_date' => $this->faker->dateTime(),
            'deadline' => $this->faker->dateTimeBetween('+1 days', '+10 days'),
        ];
    }
}
