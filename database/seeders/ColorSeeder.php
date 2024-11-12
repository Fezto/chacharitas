<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Azul'],
            ['name' => 'Rosa'],
            ['name' => 'Blanco'],
            ['name' => 'Gris'],
            ['name' => 'Verde'],
            ['name' => 'Amarillo'],
            ['name' => 'Negro'],
            ['name' => 'Rojo'],
            ['name' => 'Naranja'],
            ['name' => 'Morado'],
            ['name' => 'Negro']
        ];


        foreach ($data as $item) {
            Color::create($item);
        }
    }
}
