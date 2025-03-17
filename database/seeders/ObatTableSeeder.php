<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('obats')->insert([
            [
                'nama_obat' => 'Paracetamol',
                'kemasan' => 'Strip',
                'harga' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kemasan' => 'Botol',
                'harga' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'kemasan' => 'Box',
                'harga' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kemasan' => 'Strip',
                'harga' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Loratadine',
                'kemasan' => 'Box',
                'harga' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Omeprazole',
                'kemasan' => 'Kapsul',
                'harga' => 35000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Metformin',
                'kemasan' => 'Botol',
                'harga' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Cetaphil',
                'kemasan' => 'Tube',
                'harga' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Vitamin C',
                'kemasan' => 'Botol',
                'harga' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_obat' => 'Losartan',
                'kemasan' => 'Strip',
                'harga' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
