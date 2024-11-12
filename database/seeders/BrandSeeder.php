<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Chicco'],
            ['name' => 'Fisher-Price'],
            ['name' => 'Graco'],
            ['name' => 'Pampers'],
            ['name' => 'Huggies'],
            ['name' => 'BabyBjorn'],
            ['name' => 'Ergobaby'],
            ['name' => 'Burt\'s Bees Baby'],
            ['name' => 'Avent'],
            ['name' => 'Medela'],
            ['name' => 'The Honest Company'],
            ['name' => 'Nuby'],
            ['name' => 'Skip Hop'],
            ['name' => 'Johnson\'s Baby'],
            ['name' => 'Tommee Tippee'],
            ['name' => 'UPPAbaby'],
            ['name' => 'Carter\'s'],
            ['name' => 'Gerber'],
            ['name' => 'Mustela'],
            ['name' => 'Mam'],
        ];


        foreach ($data as $item){
            Brand::create($item);
        }
    }
}
