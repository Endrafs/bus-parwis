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
        'harga_sewa_unit',
        'biaya_tol',
        'biaya_solar',
        'tips_crew',
        'biaya_parkir',
        'biaya_tujuan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali'   => 'date',
        'total_harga'       => 'decimal:2',
        'harga_sewa_unit'   => 'decimal:2',
        'biaya_tol'         => 'decimal:2',
        'biaya_solar'       => 'decimal:2',
        'tips_crew'         => 'decimal:2',
        'biaya_parkir'      => 'decimal:2',
        'biaya_tujuan'      => 'decimal:2',
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

    /**
     * Total pembayaran yang sudah disetujui (DP + Pelunasan).
     */
    public function getTotalDibayarAttribute(): float
    {
        return (float) $this->payments()
            ->where('status_verifikasi', 'Disetujui')
            ->sum('nominal');
    }

    /**
     * Sisa pembayaran yang harus dibayar.
     */
    public function getSisaPembayaranAttribute(): float
    {
        $sisa = (float) $this->total_harga - $this->total_dibayar;
        return max(0, $sisa);
    }

    /**
     * Cek apakah booking sudah lunas.
     */
    public function getIsLunasAttribute(): bool
    {
        return $this->sisa_pembayaran <= 0;
    }

    /**
     * Cek apakah DP sudah dibayar dan disetujui.
     */
    public function getDpSudahDibayarAttribute(): bool
    {
        return $this->payments()
            ->where('jenis_pembayaran', 'DP')
            ->where('status_verifikasi', 'Disetujui')
            ->exists();
    }

    /**
     * Hitung total_harga berdasarkan komponen biaya.
     */
    public static function hitungTotalHarga(
        float $hargaSewaUnit,
        int $jumlahHari,
        float $biayaTol = 0,
        float $biayaSolar = 0,
        float $tipsCrew = 0,
        float $biayaParkir = 0,
        float $biayaTujuan = 0
    ): float {
        return ($jumlahHari * $hargaSewaUnit) + $biayaTol + $biayaSolar + $tipsCrew + $biayaParkir + $biayaTujuan;
    }
}