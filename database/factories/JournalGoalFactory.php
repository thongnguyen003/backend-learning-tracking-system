<?php

namespace Database\Factories;
use App\Models\JournalGoal;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Journal;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalGoal>
 */
class JournalGoalFactory extends Factory
{
    protected $model = JournalGoal::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journal_id' => Journal::factory(),
            'title' => $this->faker->sentence(),
            'state' => 1,
            'date' => $this->faker->dateTime(),
        ];
    }
}
