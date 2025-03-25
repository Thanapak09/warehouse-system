<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'zone_id' => 1, // override later
            'code' => strtoupper($this->faker->bothify('??-###')),
            'max_weight' => rand(50, 200),
            'max_volume' => $this->faker->randomFloat(2, 0.5, 2.0),
            'allowed_product_type' => null,
        ];        
    }
}
