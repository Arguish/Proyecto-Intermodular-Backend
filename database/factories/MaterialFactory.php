<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalQuantity = $this->faker->numberBetween(1, 100);
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'barcode' => $this->faker->unique()->ean13(),
            'available_quantity' => $this->faker->numberBetween(0, $totalQuantity),
            'total_quantity' => $totalQuantity,
            'location' => $this->faker->word(),
            'category' => $this->faker->randomElement(['Electronics', 'Furniture', 'Books', 'Tools', 'Sports', 'Lab Equipment']),
            'image_url' => $this->faker->optional()->imageUrl(640, 480, 'technics'),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
