<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Address::create([
            'street' => 'Lomas del mirador',
            'street_number' => '111',
            'neighborhood_id' => 220062870,
        ]);

        Address::create([
            'street' => 'Lomas del mirador',
            'street_number' => '111',
            'neighborhood_id' => 220062870,
        ]);


    }
}
