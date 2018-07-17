<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'spotify_account_id',
    ];

    /**
     * Eloquent relationship where Account belongs-to a Playlist
     */
    public function playlist()
    {
        return $this->belongsTo(Account::class, 'owner_id', 'spotify_account_id');
    }
}
