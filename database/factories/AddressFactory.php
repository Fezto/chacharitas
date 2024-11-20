<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street' => fake()->streetName(),
            'neighborhood_id' => DB::table('neighborhoods')->inRandomOrder()->first()->id,
            'street_number' => fake()->buildingNumber(),
            'unit_number' => fake()->optional(0.3)->buildingNumber(),
        ];
    }
}
