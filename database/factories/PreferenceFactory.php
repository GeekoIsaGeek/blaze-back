<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preference>
 */
class PreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minAge = fake()->numberBetween(18, 88);

        return [
            'gender' => fake()->randomElement(['male', 'female','everyone']),
            'age_from' => $minAge,
            'age_to' => fake()->numberBetween($minAge + 1, 90),
            'user_id' => User::factory()
        ];
    }
}
