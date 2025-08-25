<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Menggunakan words(2, true) untuk menghasilkan 2 kata acak sebagai nama menu
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(8),
            'price' => fake()->randomFloat(2, 5000, 100000),
            'image_url' => 'https://via.placeholder.com/300x200.png?text=' . str_replace(' ', '+', fake()->word()),
        ];
    }
}