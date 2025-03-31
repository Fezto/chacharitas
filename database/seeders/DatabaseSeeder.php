<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            MunicipalitySeeder::class,
            NeighborhoodSeeder::class,
            AddressSeeder::class,
            GenderSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ColorSeeder::class,
            MaterialSeeder::class,
            SizeSeeder::class,
            BrandSeeder::class,
            RoleSeeder::class,
            ProductSeeder::class
        ]);
    }
}
