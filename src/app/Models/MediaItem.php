<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaItem extends Model
{
    protected $fillable = [
        'page_section_id',
        'media_type',
        'file_path',
        'youtube_url',
        'caption',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function pageSection(): BelongsTo
    {
        return $this->belongsTo(PageSection::class);
    }

    public function getUrlAttribute(): ?string
    {
        return match ($this->media_type) {
            'image', 'video' => $this->file_path ? asset('storage/' . $this->file_path) : null,
            'youtube' => $this->getYoutubeEmbedUrl(),
            default => null,
        };
    }

    public function getYoutubeEmbedUrl(): ?string
    {
        if ($this->media_type !== 'youtube' || empty($this->youtube_url)) {
            return null;
        }

        $patterns = [
            '/youtube\\.com\\/watch\\?v=([a-zA-Z0-9_-]+)/',
            '/youtu\\.be\\/([a-zA-Z0-9_-]+)/',
            '/youtube\\.com\\/embed\\/([a-zA-Z0-9_-]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->youtube_url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        return $this->youtube_url;
    }
}
