<?php

namespace App\T3\Services;

use DB;
use Exception;
use App\Models\Track;
use App\Models\Playlist;
use App\T3\Spotify\Client;
use Illuminate\Http\Request;
use App\Http\Requests\SpotifyPlaylistRequest;
use App\T3\Spotify\Transformers\PlaylistTransformer;

class CreatePlaylistService implements Service
{
    /**
     * @var App\Models\Track
     */
    private $track;

    /**
     * @var App\Models\Playlist
     */
    private $playlist;

    /**
     * @var App\T3\Spotify\Client
     */
    private $spotify;

    /**
     * Create a new class instance.
     *
     * @param App\Models\Track $track
     * @param App\Models\Playlist $playlist
     * @param App\T3\Spotify\Client $spotify
     * @return void
     */
    public function __construct(Track $track, Playlist $playlist, Client $spotify)
    {
        $this->track = $track;
        $this->playlist = $playlist;
        $this->spotify = $spotify;
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
        $createdPlaylist = $this->createPlaylist($playlist);

        return $createdPlaylist;
    }

    /**
     * Transactionally attempt to save the Playlist and attach
     * new or existing Tracks to the Playlist.
     *
     * @param array $playlist
     * @return array
     * @throws Exception
     */
    private function createPlaylist(array $playlist)
    {
        DB::transaction(function () use ($playlist) {
            $created = $this->playlist->create($playlist);

            foreach ($playlist['tracks'] as $track) {
                // Find Track with matching Spotify ID
                $duplicate = $this->track->where('spotify_track_id', $track['spotify_track_id'])->first();

                if ($duplicate) {
                    // Track exists, attach it to the new playlist
                    $created->tracks()->attach($duplicate);
                } else {
                    // Track doesn't exist, create new
                    $this->track->create($track)->playlists()->attach($created);
                }
            }
        });

        return $playlist;
    }
}
