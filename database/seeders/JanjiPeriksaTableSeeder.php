<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Prompts\Table;

class JanjiPeriksaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::Table('janji_periksas')->insert([
            [
                'id_pasien' => 3,
                'id_jadwal_periksa' => 1,
                'keluhan' => 'Batuk kering',
                'no_antrian' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pasien' => 3,
                'id_jadwal_periksa' => 2,
                'keluhan' => 'Demam tinggi',
                'no_antrian' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pasien' => 5,
                'id_jadwal_periksa' => 2,
                'keluhan' => 'Demam tinggi',
                'no_antrian' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pasien' => 3,
                'id_jadwal_periksa' => 1,
                'keluhan' => 'Demam tinggi bangettt',
                'no_antrian' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
