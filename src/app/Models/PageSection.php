<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageSection extends Model
{
    protected $fillable = [
        'page',
        'section_key',
        'title',
        'subtitle',
        'description',
        'media_type',
        'media_path',
        'media_url',
        'metadata',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Scope to get active sections for a specific page, ordered by sort_order.
     */
    public function scopeForPage($query, string $page)
    {
        return $query->where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    /**
     * Get a specific section by page and section_key.
     */
    public static function getSection(string $page, string $sectionKey): ?self
    {
        return static::where('page', $page)
            ->where('section_key', $sectionKey)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get a YouTube embed URL from a regular YouTube URL.
     */
    public function mediaItems(): HasMany
    {
        return $this->hasMany(MediaItem::class)->orderBy('sort_order');
    }

    public function getYoutubeEmbedUrl(): ?string
    {
        if ($this->media_type !== 'youtube' || empty($this->media_url)) {
            return null;
        }

        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->media_url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        return $this->media_url;
    }
}
