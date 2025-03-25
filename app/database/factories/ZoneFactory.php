<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_id' => 1, // จะถูก override จาก Seeder
            'name' => $this->faker->word . ' Zone',
            'type' => 'storage',
            'temperature' => rand(18, 30),
            'humidity' => rand(30, 80),
            'security_level' => 'medium',
        ];
    }
}
