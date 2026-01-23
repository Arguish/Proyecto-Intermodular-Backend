<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Aula 101',
                'barcode' => 'AULA-101-BC',
                'description' => 'Aula de informática con 30 ordenadores',
            ],
            [
                'name' => 'Aula 102',
                'barcode' => 'AULA-102-BC',
                'description' => 'Aula de informática con proyector',
            ],
            [
                'name' => 'Aula 201',
                'barcode' => 'AULA-201-BC',
                'description' => 'Aula multimedia',
            ],
            [
                'name' => 'Laboratorio 1',
                'barcode' => 'LAB-001-BC',
                'description' => 'Laboratorio de ciencias',
            ],
            [
                'name' => 'Salón de Actos',
                'barcode' => 'SALON-001-BC',
                'description' => 'Salón con capacidad para 200 personas',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
