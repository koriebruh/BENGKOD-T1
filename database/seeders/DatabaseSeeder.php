<?php

namespace Database\Seeders;

use App\Models\DetailPeriksa;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //CALL ALL DATA WANT SEEDER
        $this->call([
            UsersTableSeeder::class,
            PeriksaTableSeeder::class,
            ObatTableSeeder::class,
            DetailPeriksa::class,
        ]);
    }
}
