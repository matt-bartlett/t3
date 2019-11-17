<?php

namespace App\Models;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
     * Eloquent relationship where Track has-many Playlist
     */
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)->withTimestamps();
    }

    /**
     * Scope a query to search for tracks matching the search term
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $searchTerm
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('artist', 'like', '%' . $searchTerm . '%')
            ->orWhere('album', 'like', '%' . $searchTerm . '%')
            ->orWhere('title', 'like', '%' . $searchTerm . '%');
    }
}
