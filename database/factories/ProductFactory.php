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
            'slug'    => fake()->slug(10),
            'designation' => fake()->domainWord(),
            'lower_limit'    => rand(2, 5),
            'stock'    => rand(5, 20)
        ];
    }
}
