<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'name' => 'Portátil HP EliteBook',
                'barcode' => 'LAPTOP-001-BC',
                'status' => 'disponible',
            ],
            [
                'name' => 'Portátil Dell Latitude',
                'barcode' => 'LAPTOP-002-BC',
                'status' => 'disponible',
            ],
            [
                'name' => 'Proyector Epson EB-X41',
                'barcode' => 'PROJ-001-BC',
                'status' => 'disponible',
            ],
            [
                'name' => 'Proyector BenQ MH550',
                'barcode' => 'PROJ-002-BC',
                'status' => 'averiado',
            ],
            [
                'name' => 'Tablet Samsung Galaxy Tab',
                'barcode' => 'TABLET-001-BC',
                'status' => 'disponible',
            ],
            [
                'name' => 'Cámara Canon EOS 2000D',
                'barcode' => 'CAM-001-BC',
                'status' => 'disponible',
            ],
            [
                'name' => 'Micrófono Rode NT1-A',
                'barcode' => 'MIC-001-BC',
                'status' => 'en_mantenimiento',
            ],
            [
                'name' => 'Router Cisco 2911',
                'barcode' => 'ROUTER-001-BC',
                'status' => 'disponible',
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
