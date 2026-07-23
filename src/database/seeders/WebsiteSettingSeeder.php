<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteSetting::query()->delete();

        WebsiteSetting::create([
            'nama_website' => 'Bus Parwis',
            'deskripsi' => 'Tersedia Big Bus & Medium Bus dengan berbagai fasilitas modern untuk perjalanan wisata Anda. Booking mudah, harga transparan!',
            'nomor_whatsapp' => '6281353433110',
            'email' => 'info@busparwis.test',
            'alamat' => 'Jl. Pariwisata No. 123, Jakarta',
            'rekening_bank' => "BCA 1234567890\na.n. PT Bus Parwis Indonesia",
        ]);
    }
}
