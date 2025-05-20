<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPeriksaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokterIds = [1, 2, 3];

        // Hari kerja: Senin (1) sampai Jumat (5)
        $workdays = [1, 2, 3, 4, 5];

        foreach ($dokterIds as $id) {
            // Ambil hari acak antara Senin sampai Jumat dalam minggu ini atau minggu depan
            do {
                $randomDate = Carbon::now()->addDays(rand(1, 14));
            } while (!in_array($randomDate->dayOfWeekIso, $workdays));

            DB::table('jadwal_periksa')->insert([
                'id_dokter'   => $id,
                'hari'        => $randomDate->toDateString(),
                'jam_mulai'   => '08:00:00',
                'jam_selesai' => '12:00:00',
                'status'      => 'tersedia',
            ]);
        }
    }
}
