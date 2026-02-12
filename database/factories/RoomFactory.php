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
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'capacity' => $this->faker->numberBetween(5, 50),
            'location' => $this->faker->word(),
            'amenities' => $this->faker->randomElements(['Projector', 'Whiteboard', 'WiFi', 'Air Conditioning', 'Sound System', 'Computers'], $this->faker->numberBetween(1, 4)),
            'is_active' => $this->faker->boolean(95), // 95% chance of being active
            'image_url' => $this->faker->optional()->imageUrl(640, 480, 'business'),
        ];
    }
}
