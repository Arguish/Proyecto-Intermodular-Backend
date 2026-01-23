<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@iesrincon.es',
            'password' => Hash::make('admin123'),
            'department' => 'Administración',
            'role' => 'admin',
        ]);

        // Profesores
        User::create([
            'name' => 'Andrea García',
            'email' => 'andrea@iesrincon.es',
            'password' => Hash::make('profesor123'),
            'department' => 'Informática',
            'role' => 'profesor',
        ]);

        User::create([
            'name' => 'Javier López',
            'email' => 'javier@iesrincon.es',
            'password' => Hash::make('profesor123'),
            'department' => 'Informática',
            'role' => 'profesor',
        ]);

        User::create([
            'name' => 'María Fernández',
            'email' => 'maria@iesrincon.es',
            'password' => Hash::make('profesor123'),
            'department' => 'Matemáticas',
            'role' => 'profesor',
        ]);
    }
}
