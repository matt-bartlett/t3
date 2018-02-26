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
        return app('PlaylistDurationFormatter')->format($this->tracks);
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
            return $this->account->name;
        }

        return $this->owner_id;
    }
}
