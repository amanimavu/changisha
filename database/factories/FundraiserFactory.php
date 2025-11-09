<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fundraiser>
 */
class FundraiserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::factory(),
            "profile_picture" => fake()->image(),
            "dob" => fake()->date(),
            "id_number" => fake()->unique()->randomNumber(6, true)
        ];
    }
}
