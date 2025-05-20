<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;
use App\Models\JournalGoal;
use App\Models\CourseGoal;
use App\Models\JournalClasses;
use App\Models\JournalSelf;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journal_goal_id' => 3,
            'course_goal_id' => null,
            'journal_class_id' => null,
            'journal_self_id' => null,
        ];
    }
}
