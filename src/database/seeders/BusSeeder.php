<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bus::query()->delete();

        Bus::insert([
            [
                'nama_bus'      => 'Big Bus SHD Single Glass',
                'kategori_bus'  => 'Big Bus',
                'tipe_bus'      => 'SHD Single Glass',
                'kapasitas'     => 50,
                'harga_sewa'    => 4000000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Big Bus SHD Double Glass',
                'kategori_bus'  => 'Big Bus',
                'tipe_bus'      => 'SHD Double Glass',
                'kapasitas'     => 59,
                'harga_sewa'    => 4500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Medium Bus',
                'kategori_bus'  => 'Medium Bus',
                'tipe_bus'      => 'Medium',
                'kapasitas'     => 30,
                'harga_sewa'    => 2500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}