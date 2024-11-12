<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaregorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Ropa'],
            ['name' => 'Calzado'],
            ['name' => 'Accesorios'],
            ['name' => 'Pañales y Cambiadores'],
            ['name' => 'Juguetes y Entretenimiento'],
            ['name' => 'Carriolas y Sillas de Paseo'],
            ['name' => 'Mobiliario y Decoración'],
            ['name' => 'Alimentación'],
            ['name' => 'Baño y Cuidado Personal'],
            ['name' => 'Portabebés y Mochilas'],
        ];

        foreach ($data as $item) {
            Category::create($item);
        }
    }
}
