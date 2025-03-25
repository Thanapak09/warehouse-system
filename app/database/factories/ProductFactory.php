<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-####')),
            'name' =>  $this->faker->words(2, true),
            'barcode' => $this->faker->ean13(),
            'type' => $this->faker->randomElement(['normal', 'expiring', 'hazardous']),
            'cost_method' => $this->faker->randomElement(['fifo', 'lifo', 'average']),
        ];
        
    }
}
