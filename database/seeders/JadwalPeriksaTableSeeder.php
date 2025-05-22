<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPeriksaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_periksa')->insert([
            [
                'id_dokter'=>2,
                'hari'=>'senin',
                'jam_mulai'=>'08:00:00',
                'jam_selesai'=>'08:00:00',
                'status'=>true
            ],[
                'id_dokter'=>4,
                'hari'=>'senin',
                'jam_mulai'=>'08:00:00',
                'jam_selesai'=>'08:00:00',
                'status'=>true
            ],[
                'id_dokter'=>6,
                'hari'=>'senin',
                'jam_mulai'=>'08:00:00',
                'jam_selesai'=>'08:00:00',
                'status'=>true
            ],
        ]);
    }
}
