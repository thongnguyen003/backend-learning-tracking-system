<?php

namespace Database\Factories;
use App\Models\JournalSelf;
use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalSelf>
 */
class JournalSelfFactory extends Factory
{
    protected $model = JournalSelf::class;
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
            'duration' => $this->faker->time('H:i'),
            'resources' => $this->faker->words(3, true),
            'activity' => $this->faker->sentence(),
            'concentration' => $this->faker->boolean(),
            'follow_plan' => $this->faker->boolean(),
            'evaluation' => $this->faker->paragraph(),
            'reinforcing_learning' => $this->faker->paragraph(),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
