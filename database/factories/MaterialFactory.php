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
        return [
            'nombre' => $this->faker->words(2, true),
            'codigo' => $this->faker->unique()->word(),
            'barcode' => $this->faker->unique()->ean13(),
            'categoria' => $this->faker->randomElement(['Electronics', 'Furniture', 'Books', 'Tools', 'Sports', 'Lab Equipment']),
            'estado' => $this->faker->word(),
            'disponible' => $this->faker->boolean(90),
        ];
    }
}
