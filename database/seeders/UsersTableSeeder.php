<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'super admin min imin',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'alamat' => 'Jl. Kebon Jeruk No. 1, Jakarta',
                'no_hp' => '081234567890',
                'role' => 'admin',
                'no_ktp' => 1111111111111111,
                'no_rm' => '202201-1',
                'poli_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. John Doe',
                'email' => 'doctor1@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'alamat' => 'Jl. Kebon Jeruk No. 1, Jakarta',
                'no_hp' => '081234567890',
                'role' => 'dokter',
                'no_ktp' => 1234567890123456,
                'no_rm' => '202101-3',
                'poli_id' => 1,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'patient1@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'alamat' => 'Jl. Raya No. 10, Jakarta',
                'no_hp' => '082345678901',
                'role' => 'pasien',
                'no_ktp' => 21372678901267237,
                'no_rm' => '202201-1',
                'poli_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'doctor2@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'alamat' => 'Jl. Sutan Syahrir No. 2, Bandung',
                'no_hp' => '083456789012',
                'no_ktp' => 2137267890123459,
                'no_rm' => '202109-3',
                'poli_id' => 3,
                'role' => 'dokter',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Smith',
                'email' => 'patient2@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'alamat' => 'Jl. Merdeka No. 15, Surabaya',
                'no_hp' => '084567890123',
                'role' => 'pasien',
                'no_ktp' => 1234567890123412,
                'no_rm' => '202101-38',
                'poli_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. William Brown',
                'email' => 'doctor3@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'alamat' => 'Jl. Pahlawan No. 5, Yogyakarta',
                'no_hp' => '085678901234',
                'role' => 'dokter',
                'no_ktp' => 123456321123456,
                'no_rm' => '202101-22',
                'poli_id' => 2,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
