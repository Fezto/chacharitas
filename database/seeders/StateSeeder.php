<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{

    public function run(): void
    {
        $extern_states = DB::connection('location')->table('estados')->get();
        $states_to_insert = [];

        foreach($extern_states as $extern_state){
            $states_to_insert[] = [
                'id' => $extern_state->id,
                'name' => $extern_state->nombre,
                'country_id' => $extern_state->pais,
            ];
        }

        DB::table('states')->insert($states_to_insert);
    }
}
