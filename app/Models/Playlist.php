<?php

namespace App\Models;

use App\Models\Track;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'owner_id',
        'owner_profile_url',
        'playlist_url',
        'playlist_thumbnail_url'
    ];

    /**
     * Eloquent relationship where Playlist has-many Track
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    /**
     * Define an attribute on a Playlist to return the total playlist duration
     *
     * @return integer
     */
    public function getDurationAttribute()
    {
        $duration = $this->getTotalDuration();

        return floor(($duration / 1000) / 60);
    }

    /**
     * Calculate the total duration of all tracks within a playlist
     *
     * @return integer
     */
    private function getTotalDuration()
    {
        $total = $this->tracks->reduce(function ($carry, $track) {
            return $carry + $track->duration;
        }, 0);

        return $total;
    }
}
