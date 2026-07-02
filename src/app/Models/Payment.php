<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'jenis_pembayaran',
        'nominal',
        'bukti_transfer',
        'status_verifikasi',
        'tanggal_bayar',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}