<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserLocation>
 */
class UserLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lat' => fake()->numberBetween(0, 90),
            'lng' => fake()->numberBetween(0, 90),
            'name' => fake()->streetAddress()
            //
        ];
    }
}
