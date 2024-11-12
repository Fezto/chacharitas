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
        $data = [
            ['name' => 'Algodón'],
            ['name' => 'Poliéster'],
            ['name' => 'Madera'],
            ['name' => 'Plástico'],
            ['name' => 'Goma'],
            ['name' => 'Metal']
        ];


        foreach ($data as $item) {
            Material::create($item);
        }
    }
}
