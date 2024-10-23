<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeighborhoodSeeder extends Seeder
{
    public function run(): void
    {
        DB::connection('location')->table('colonias')->orderBy('id')->chunk(10000, function($extern_neighborhoods) {
            $neighborhoods_to_insert = [];

            foreach ($extern_neighborhoods as $extern_neighborhood) {
                $neighborhoods_to_insert[] = [
                    'id' => $extern_neighborhood->id,
                    'name' => $extern_neighborhood->nombre,
                    'city' => $extern_neighborhood->ciudad,
                    'municipality_id' => $extern_neighborhood->municipio,
                    'settlement' => $extern_neighborhood->asentamiento,
                    'postal_code' => $extern_neighborhood->codigo_postal,
                ];
            }

            DB::table('neighborhoods')->insert($neighborhoods_to_insert);
        });
    }
}
