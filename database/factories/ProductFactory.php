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
            'name' => fake()->sentence(2, false),
            'stock' => mt_rand(1, 10 ),
            'price' => mt_rand(200, 500) * 1000,
            'image' => 'product/product.jpg'
        ];
    }
}
