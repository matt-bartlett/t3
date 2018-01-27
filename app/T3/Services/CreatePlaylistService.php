<?php

namespace App\T3\Services;

use DB;
use App\Models\Playlist;
use App\T3\Spotify\Client;
use App\Http\Requests\SpotifyPlaylistRequest;
use Illuminate\Http\Request;
use App\T3\Spotify\Transformers\PlaylistTransformer;

class CreatePlaylistService implements Service
{
    /**
     * @var App\T3\Spotify\Client
     */
    private $spotify;

    /**
     * @var App\Models\Playlist
     */
    private $playlist;

    /**
     * Create a new class instance.
     *
     * @param App\Models\Playlist $playlist
     * @param App\T3\Spotify\Client $spotify
     * @return void
     */
    public function __construct(Playlist $playlist, Client $spotify)
    {
        $this->spotify = $spotify;
        $this->playlist = $playlist;
    }

    /**
     * Fetch the Spotify playlists based on the request parameters
     * and store the Playlist & Tracks to the database.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function make(Request $request)
    {
        // Fetch the Playlist from Spotify
        $playlist = $this->spotify->getApi()->getPlaylist(
            $request->get('spotify_account_id'),
            $request->get('spotify_playlist_id')
        );

        // Transform the Playlist to an array
        $playlist = $this->spotify->transform($playlist, new PlaylistTransformer);

        // Override the Playlist name if present
        if ($request->get('name')) {
            $playlist['name'] = $request->get('name');
        }

        // Save the Playlist
        DB::transaction(function () use ($playlist) {
            $this->playlist->create($playlist)->tracks()->createMany($playlist['tracks']);
        });

        return $playlist;
    }
}
