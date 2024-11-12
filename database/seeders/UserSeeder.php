<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'root',
            'last_name' => 'dios',
            'second_last_name' => 'arceus',
            'email' => 'axolotlscriptjs@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('root'),
            'phone_number' => '1234567890',
            'remember_token' => Str::random(10),
            'address_id' => Address::inRandomOrder()->first()->id,
            'gender_id' => Gender::inRandomOrder()->first()->id,
        ]);

        User::factory(20)->create();
    }
}
