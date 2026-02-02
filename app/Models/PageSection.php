<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'short_description',
        'event_date',
        'extra',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'extra' => 'array',
    ];

    /**
     * Get section by slug (static helper).
     */
    public static function getBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Get all sections keyed by slug for views.
     */
    public static function getKeyedBySlug(): \Illuminate\Support\Collection
    {
        return static::orderBy('sort_order')->get()->keyBy('slug');
    }

    /**
     * Wedding date for countdown (from wedding_day section).
     */
    public static function weddingDate(): ?\Carbon\Carbon
    {
        $section = static::getBySlug('wedding_day');
        return $section?->event_date;
    }

    /**
     * Get extra value by key.
     */
    public function getExtra(string $key, $default = null)
    {
        return data_get($this->extra, $key, $default);
    }

    /**
     * Get date formatted for the board overlay: day, month, year (month gets special font).
     * Parses extra['date'] or extra['date_display'] and always returns this format.
     *
     * @return array{day: string, month: string, year: string}|null
     */
    public function getBoardDateFormatted(): ?array
    {
        $raw = $this->getExtra('date_display') ?: $this->getExtra('date');
        if (empty($raw) || ! is_string($raw)) {
            return null;
        }
        try {
            $date = Carbon::parse(trim($raw));
            return [
                'day'   => $date->format('j'),    // e.g. 25
                'month' => $date->format('M'),    // e.g. Feb
                'year'  => $date->format('Y'),    // e.g. 2026
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
