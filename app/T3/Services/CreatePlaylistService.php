<?php

namespace App\T3\Services;

use DB;
use Exception;
use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Requests\SpotifyPlaylistRequest;
use Spotify\Resources\Playlist as SpotfiyPlaylist;
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
     * @var Spotify\Resources\Playlist
     */
    private $api;

    /**
     * @var App\T3\Spotify\Transformers\PlaylistTransformer
     */
    private $transformer;

    /**
     * Create a new class instance.
     *
     * @param App\Models\Track $track
     * @param App\Models\Playlist $playlist
     * @param Spotify\Resources\Playlist $spotify
     * @param App\T3\Spotify\Transformers\PlaylistTransformer $transformer
     *
     * @return void
     */
    public function __construct(
        Track $track,
        Playlist $playlist,
        SpotfiyPlaylist $spotify,
        PlaylistTransformer $transformer
    ) {
        $this->track = $track;
        $this->playlist = $playlist;
        $this->spotify = $spotify;
        $this->transformer = $transformer;
    }

    /**
     * Fetch the Spotify playlists based on the request parameters
     * and store the Playlist & Tracks to the database.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return array
     */
    public function handle(Request $request) : array
    {
        // Fetch the Playlist from Spotify
        $playlist = $this->spotify->getPlaylist(
            $request->get('spotify_playlist_id')
        );

        // Transform the Playlist to an array
        $playlist = $this->transformer->transform($playlist);

        // Override the Playlist name if present
        if ($request->get('name')) {
            $playlist['name'] = $request->get('name');
        }

        // Save the Playlist
        return $this->createPlaylist($playlist);
    }

    /**
     * Transactionally attempt to save the Playlist and attach
     * new or existing Tracks to the Playlist.
     *
     * @param array $playlist
     *
     * @return array
     *
     * @throws Exception
     */
    private function createPlaylist(array $playlist) : array
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
