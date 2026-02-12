<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
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
            'tipo' => $this->faker->word(),
            'capacidad' => $this->faker->numberBetween(5, 50),
            'ubicacion' => $this->faker->word(),
            'disponible' => $this->faker->boolean(95),
            'equipamiento' => $this->faker->randomElements(['Projector', 'Whiteboard', 'WiFi', 'Air Conditioning', 'Sound System', 'Computers'], $this->faker->numberBetween(1, 4)),
        ];
    }
}
