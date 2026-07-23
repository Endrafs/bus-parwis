<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    protected $fillable = [
        'nama',
        'email',
        'no_wa',
        'pesan',
        'balasan',
        'dibalas_pada',
        'dibalas_oleh',
        'status',
    ];

    protected $casts = [
        'dibalas_pada' => 'datetime',
    ];

    /**
     * Admin who replied to this message.
     */
    public function dibalasOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibalas_oleh');
    }

    /**
     * Scope for new/unread messages.
     */
    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    /**
     * Scope for replied messages.
     */
    public function scopeDibalas($query)
    {
        return $query->where('status', 'dibalas');
    }
}