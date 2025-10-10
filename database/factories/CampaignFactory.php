<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'program_category' => $this->faker->randomElement(['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan']),
            'target_amount' => $this->faker->numberBetween(1000000, 100000000),
            'collected_amount' => $this->faker->numberBetween(0, 100000000),
            'photo' => null,
            'status' => $this->faker->randomElement(['draft', 'published', 'completed', 'cancelled']),
        ];
    }
}
