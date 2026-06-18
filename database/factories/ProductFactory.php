<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'nama' => $this->faker->word(),
            'harga' => $this->faker->randomFloat(2, 10000, 500000),
            'kategori' => $this->faker->randomElement(['kaos', 'hoodie', 'topi', 'tas']),
            'stok' => $this->faker->numberBetween(0, 100),
            'bahan' => $this->faker->randomElement(['katun', 'polyester', 'dry fit']),
            'warna' => $this->faker->colorName(),
            'file' => $this->faker->word(),
            'rating' => $this->faker->randomFloat(1, 0, 5),
        ];
    }
}
