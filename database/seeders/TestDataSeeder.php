<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios de prueba (estudiantes y profesores)
        \App\Models\User::factory(10)->create();

        // Crear materiales de prueba
        \App\Models\Material::factory(20)->create();

        // Crear salas de prueba
        \App\Models\Room::factory(5)->create();

        // Crear reservas de prueba
        \App\Models\Reservation::factory(15)->create()->each(function ($reservation) {
            // Adjuntar materiales aleatorios a cada reserva (1-3 materiales)
            $materialIds = \App\Models\Material::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $reservation->materials()->attach($materialIds);
        });
    }
}
