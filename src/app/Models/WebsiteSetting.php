<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'nama_website',
        'logo',
        'deskripsi',
        'nomor_whatsapp',
        'email',
        'alamat',
        'rekening_bank',
        'biaya_tol_default',
        'biaya_solar_default',
        'tips_crew_default',
        'biaya_parkir_default',
    ];
}
