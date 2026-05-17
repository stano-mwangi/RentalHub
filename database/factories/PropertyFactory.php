<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'address' => $this->faker->address(),
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'status' => $this->faker->randomElement(['vacant', 'occupied']),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'image_path' => null, // You can set up fake images if needed
        ];
    }
}
