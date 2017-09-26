<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'playlist_id',
        'title',
        'artist',
        'album',
        'duration',
        'spotify_track_id',
        'spotify_url',
        'spotify_preview_url',
        'spotify_thumbnail_url'
    ];

    /**
     * Define an attribute on a Track to return its duration
     *
     * @return string
     */
    public function getDurationFormattedAttribute()
    {
        $duration = $this->duration;

        $seconds = floor($duration / 1000) % 60;

        if (strlen($seconds) == 1) {
            $seconds = '0' . $seconds;
        }

        $minutes = floor(($duration / 1000) / 60) % 60;

        return $minutes . ':' . $seconds;
    }

    /**
     * Scope a query to search for tracks matching the search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $searchTerm
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('artist', 'like', '%' . $searchTerm . '%')
            ->orWhere('album', 'like', '%' . $searchTerm . '%')
            ->orWhere('title', 'like', '%' . $searchTerm . '%');
    }
}
