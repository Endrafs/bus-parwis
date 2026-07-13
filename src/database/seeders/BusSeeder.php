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
                'nama_bus'      => 'Jetbus 5',
                'kategori_bus'  => 'Big Bus',
                'tipe_bus'      => 'Jetbus 5 SHD Single Glass',
                'kapasitas'     => 50,
                'harga_sewa'    => 4000000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Jetbus 5',
                'kategori_bus'  => 'Big Bus',
                'tipe_bus'      => 'Jetbus 5 SHD',
                'kapasitas'     => 59,
                'harga_sewa'    => 4500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Jetbus 5',
                'kategori_bus'  => 'Big Bus MHD',
                'tipe_bus'      => 'Jetbus 5 Medium Deck',
                'kapasitas'     => 50,
                'harga_sewa'    => 3500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Jetbus 5',
                'kategori_bus'  => 'Big Bus',
                'tipe_bus'      => 'Jetbus 5 Jumbo',
                'kapasitas'     => 60,
                'harga_sewa'    => 5000000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Medium Bus',
                'kategori_bus'  => 'Medium Bus',
                'tipe_bus'      => 'Travel',
                'kapasitas'     => 30,
                'harga_sewa'    => 2500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Jetbus 3+',
                'kategori_bus'  => 'Big Bus MHD',
                'tipe_bus'      => 'Jetbus 3+ Medium High Deck Single Glass',
                'kapasitas'     => 50,
                'harga_sewa'    => 2500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_bus'      => 'Travel Car',
                'kategori_bus'  => 'Travel Car',
                'tipe_bus'      => 'Travel',
                'kapasitas'     => 7,
                'harga_sewa'    => 1500000,
                'foto'          => null,
                'status'        => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}