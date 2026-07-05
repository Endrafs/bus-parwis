<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationPrice extends Model
{
    protected $fillable = [
        'nama_tujuan',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];
}
