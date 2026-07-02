<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'bus_id',
        'kode_booking',
        'tanggal_berangkat',
        'tanggal_kembali',
        'tujuan',
        'jumlah_hari',
        'total_harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali'   => 'date',
        'total_harga'       => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {

            if (!$booking->kode_booking) {

                $last = Booking::latest('id')->first();

                $number = $last ? $last->id + 1 : 1;

                $booking->kode_booking =
                    'BUS-' .
                    now()->format('Ymd') .
                    '-' .
                    str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}