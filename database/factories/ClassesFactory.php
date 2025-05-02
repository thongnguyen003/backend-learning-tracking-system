<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classes;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClassesFactory extends Factory
{
    protected $model = Classes::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Class ' . $this->faker->unique()->numberBetween(1, 100),
            'quantity' => $this->faker->numberBetween(10, 50),
            'start_day' => $this->faker->date(),
            'end_day' => $this->faker->dateTimeBetween('+1 week', '+6 months')->format('Y-m-d'),
            'state' => $this->faker->numberBetween(0, 2),
        ];
    }
}
