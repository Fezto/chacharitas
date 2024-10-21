<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $extern_countries = DB::connection('location')->table('paises')->get();
        $countries_to_insert = [];

        foreach($extern_countries as $extern_country) {
            $countries_to_insert[] = [
                "id" => $extern_country->id,
                "name" => $extern_country->nombre,
            ];
        }

        DB::table('countries')->insert($countries_to_insert);
    }
}
