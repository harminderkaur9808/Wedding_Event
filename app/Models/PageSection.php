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
     * Get date formatted for the board overlay: day, month, year (board format).
     * Uses the same extra['date'] as the section's "Date: ..." detail so board and details always match.
     *
     * @return array{day: string, month: string, year: string}|null
     */
    public function getBoardDateFormatted(): ?array
    {
        $raw = $this->getExtra('date');
        if (empty($raw) || ! is_string($raw)) {
            return null;
        }
        $raw = trim($raw);
        $date = null;
        $formats = ['n/j/Y', 'm/d/Y', 'm-d-Y', 'n-j-Y', 'Y-m-d', 'd-m-Y', 'd/m/Y'];
        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $raw);
                break;
            } catch (\Exception $e) {
                continue;
            }
        }
        if (! $date) {
            try {
                $date = Carbon::parse($raw);
            } catch (\Exception $e) {
                return null;
            }
        }
        return [
            'day'   => $date->format('j'),
            'month' => $date->format('M'),
            'year'  => $date->format('Y'),
        ];
    }

    /**
     * Get date as a single display string (e.g. "3 Mar 2026") so "Date: ..." and board always match.
     * Uses the same parsing as getBoardDateFormatted().
     */
    public function getDateDisplayString(?string $fallback = null): ?string
    {
        $board = $this->getBoardDateFormatted();
        if (! $board) {
            return $fallback;
        }
        return $board['day'] . ' ' . $board['month'] . ' ' . $board['year'];
    }
}
