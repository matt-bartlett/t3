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
}
