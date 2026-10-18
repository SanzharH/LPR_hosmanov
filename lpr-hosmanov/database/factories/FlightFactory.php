<?php

namespace Database\Factories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    public function definition(): array
    {
        return [
            'airport_id' => Airport::factory(),
            'number' => fake()->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'description' => fake()->optional()->sentence(),
            'departure_at' => fake()->dateTimeBetween('-1 month', '+2 months'),
            'seats' => fake()->numberBetween(60, 250),
            'ticket_price' => fake()->randomFloat(2, 10000, 150000),
            'is_international' => fake()->boolean(),
        ];
    }
}