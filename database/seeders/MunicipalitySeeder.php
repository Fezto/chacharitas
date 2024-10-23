<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipalitySeeder extends Seeder
{
    public function run(): void
    {
        $extern_municipalities = DB::connection('location')->table('municipios')->get();
        $municipalities_to_insert = [];

        foreach ($extern_municipalities as $extern_municipality) {
            $municipalities_to_insert[] = [
                'id' => $extern_municipality->id,
                'name' => $extern_municipality->nombre,
                'state_id' => $extern_municipality->estado,
            ];
        }

        DB::table('municipalities')->insert($municipalities_to_insert);


    }
}
