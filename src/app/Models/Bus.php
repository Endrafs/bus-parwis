<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bus',
        'kategori_bus',
        'tipe_bus',
        'kapasitas',
        'harga_sewa',
        'foto',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'harga_sewa' => 'decimal:2',
    ];

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            BusFacility::class,
            'bus_bus_facility'
        );
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Cek ketersediaan bus pada rentang tanggal tertentu.
     * Return true jika bus tersedia (tidak bentrok dengan booking lain).
     */
    public function isAvailable(string $tanggalBerangkat, string $tanggalKembali, ?int $excludeBookingId = null): bool
    {
        $query = $this->bookings()
            ->whereNotIn('status', ['Dibatalkan'])
            ->where(function ($q) use ($tanggalBerangkat, $tanggalKembali) {
                $q->whereBetween('tanggal_berangkat', [$tanggalBerangkat, $tanggalKembali])
                  ->orWhereBetween('tanggal_kembali', [$tanggalBerangkat, $tanggalKembali])
                  ->orWhere(function ($sub) use ($tanggalBerangkat, $tanggalKembali) {
                      $sub->where('tanggal_berangkat', '<=', $tanggalBerangkat)
                          ->where('tanggal_kembali', '>=', $tanggalKembali);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return ! $query->exists();
    }
}