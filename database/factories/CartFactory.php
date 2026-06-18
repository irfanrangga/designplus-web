<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => $this->faker->numberBetween(1, 10),
            'material' => $this->faker->word(),
            'warna' => $this->faker->colorName(),
            'custom_file' => $this->faker->word(),
            'note' => $this->faker->sentence(),
            'is_selected' => $this->faker->randomElement([true, false]),
        ];
    }
}
