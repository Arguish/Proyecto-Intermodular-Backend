<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s') . ' +8 hours');

        return [
            'user_id' => $this->faker->numberBetween(1, 10), // Assuming users 1-10 exist
            'room_id' => $this->faker->numberBetween(1, 5), // Assuming rooms 1-5 exist
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'cancelled']),
            'purpose' => $this->faker->sentence(),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
