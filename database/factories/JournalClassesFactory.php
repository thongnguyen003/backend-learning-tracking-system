<?php

namespace Database\Factories;
use App\Models\JournalClasses;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Journal;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalClasses>
 */
class JournalClassesFactory extends Factory
{
    protected $model = JournalClasses::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journal_id' => Journal::factory(),
            'date' => $this->faker->date(),
            'topic' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'assessment' => $this->faker->numberBetween(1, 10),
            'difficulty' => $this->faker->word(),
            'plan' => $this->faker->paragraph(),
            'solution' => $this->faker->paragraph(),
        ];
    }
}
