<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusFacility extends Model
{
    protected $fillable = [
        'nama_fasilitas',
    ];

    public function buses(): BelongsToMany
    {
        return $this->belongsToMany(
            Bus::class,
            'bus_bus_facility'
        );
    }
}