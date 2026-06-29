<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        Bus::insert([
            [
                'nama_bus' => 'Big Bus SHD',
                'kategori_bus' => 'Big Bus',
                'tipe_bus' => 'Single Glass',
                'kapasitas' => 50,
                'harga_sewa' => 4000000,
                'status' => true,
            ],
            [
                'nama_bus' => 'Big Bus SHD',
                'kategori_bus' => 'Big Bus',
                'tipe_bus' => 'Double Glass',
                'kapasitas' => 59,
                'harga_sewa' => 4500000,
                'status' => true,
            ],
            [
                'nama_bus' => 'Medium Bus',
                'kategori_bus' => 'Medium Bus',
                'tipe_bus' => 'Standard',
                'kapasitas' => 30,
                'harga_sewa' => 2500000,
                'status' => true,
            ],
        ]);
    }
}