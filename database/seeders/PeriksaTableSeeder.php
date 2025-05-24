<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriksaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('periksas')->insert([
            [
                'id_pasien' => 3,
                'id_janji_periksa' => 1,
                'tgl_periksa' => now(),
                'catatan' => 'Pemeriksaan rutin, pasien dalam keadaan sehat.',
                'biaya_periksa' => 200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pasien' => 5,
                'id_janji_periksa' => 2,
                'tgl_periksa' => now()->addDays(1),
                'catatan' => 'Pasien mengalami batuk dan demam.',
                'biaya_periksa' => 250000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pasien' => 5,
                'id_janji_periksa' => 3,
                'tgl_periksa' => now()->addDays(2),
                'catatan' => 'Pemeriksaan kulit, ditemukan ruam merah.',
                'biaya_periksa' => 300000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ,[
                'id_pasien' => 3,
                'id_janji_periksa' => 4,
                'tgl_periksa' => now()->addDays(2),
                'catatan' => 'Pemeriksaan kulit, ditemukan ruam merah.',
                'biaya_periksa' => 300000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
