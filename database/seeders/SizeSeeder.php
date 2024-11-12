<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Recién nacido'],
            ['name' => '0-3 meses'],
            ['name' => '3-6 meses'],
            ['name' => '6-12 meses'],
            ['name' => '12-18 meses'],
            ['name' => '18-24 meses']
        ];


        foreach ($data as $item) {
            Size::create($item);
        }
    }
}
