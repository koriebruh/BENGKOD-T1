<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('poli')->insert([
            [
                'nama_poli' => 'Poli Umum',
                'keterangan' => 'Pelayanan kesehatan umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_poli' => 'Poli Gigi',
                'keterangan' => 'Pelayanan kesehatan gigi dan mulut',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_poli' => 'Poli Anak',
                'keterangan' => 'Pelayanan kesehatan anak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
