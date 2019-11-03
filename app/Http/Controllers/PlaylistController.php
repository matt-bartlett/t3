<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\JsonResponse;
use App\T3\Transformers\PlaylistTransformer;

class PlaylistController extends Controller
{
    /**
     * @var App\Models\Playlist
     */
    private $playlist;

    /**
     * Initialise the controller
     *
     * @param App\Models\Playlist $playlist
     */
    public function __construct(Playlist $playlist)
    {
        $this->playlist = $playlist;
    }

    /**
     * Return paginated list of Playlists
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $playlists = $this->playlist->latest()->paginate(24);

        $playlists = fractal($playlists, new PlaylistTransformer)->toArray();

        return response()->json($playlists);
    }

    /**
     * Return paginated list of Tracks for a specified Playlist
     *
     * @param integer $id
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function show($id) : JsonResponse
    {
        $playlist = $this->playlist->findOrFail($id);

        $playlist = fractal($playlist, new PlaylistTransformer)
            ->includeTracks()
            ->toArray();

        return response()->json($playlist);
    }
}
