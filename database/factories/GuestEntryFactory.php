<?php

namespace Database\Factories;

use App\Models\GuestEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GuestEntry>
 */
class GuestEntryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->numerify('08##########'),
            'organization' => fake()->optional()->company(),
            'met_with' => fake()->name(),
            'purpose' => fake()->randomElement(['Silaturahmi', 'Pekerjaan', 'Acara', 'Lainnya']),
            'message' => fake()->sentence(),
        ];
    }
}
