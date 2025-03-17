<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPeriksaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_periksas')->insert([
            [
                'id_periksa' => 1,  // ID periksa yang ada di tabel periksas
                'id_obat' => 1,     // ID obat yang ada di tabel obats
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_periksa' => 1,
                'id_obat' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_periksa' => 2,
                'id_obat' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
