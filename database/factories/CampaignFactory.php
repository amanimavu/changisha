<?php

namespace Database\Factories;

use App\Enum\Status;
use App\Models\Category;
use App\Models\Fundraiser;
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
        $start_date = fake()->dateTimeThisMonth();

        return [
            'title'          => fake()->text(50),
            'description'    => fake()->paragraph(20),
            'start_date'     => $start_date->format('Y-m-d'),
            'end_date'       => fake()->dateTimeBetween($start_date, '+2 months')->format('Y-m-d'),
            'goal'           => fake()->numberBetween(50000, 300000),
            'funds_raised'   => fake()->numberBetween(50000, 300000),
            'status'         => fake()->randomElement(Status::class),
            'campaign_image' => fake()->imageUrl(category: 'aid'),
            'paybill_number' => fake()->randomNumber(5),
            'privacy'        => fake()->randomElement(['public', 'private']),
            'verified'       => fake()->randomElement([1, 0]),

            'fundraiser_id' => Fundraiser::factory(),
            'category_id'   => Category::factory(),
        ];
    }
}
