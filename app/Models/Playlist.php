<?php

namespace App\Models;

use App\Models\Track;
use App\Models\Account;
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
     * Eloquent relationship where Account belongs-to a Playlist
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'owner_id', 'spotify_account_id');
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
     * Return the Account display name if a relationship exists, else
     * return the Owner ID from Spotify
     *
     * @return string
     */
    public function getOwnerNameAttribute()
    {
        if ($this->account) {
            return $owner = $this->account->name;
        }

        return $this->owner_id;
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
