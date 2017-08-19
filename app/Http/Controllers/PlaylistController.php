<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
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
     * Action divided to handle both Web & API calls
     *
     * @return Illuminate\Http\Response|Illuminate\View\View
     */
    public function index()
    {
        $playlists = $this->playlist->latest()->paginate(15);

        if (request()->expectsJson()) {
            $playlists = fractal($playlists, new PlaylistTransformer)->toArray();

            return response()->json($playlists);
        }

        return view('playlists/index', compact('playlists'));
    }

    /**
     * Return paginated list of Tracks for a specified Playlist
     * Action divided to handle both Web & API calls
     *
     * @param App\Models\Playlist $playlist
     * @return Illuminate\Http\Response|Illuminate\View\View
     */
    public function show(Playlist $playlist)
    {
        $playlist = $this->playlist->findOrFail($playlist->id);

        if (request()->expectsJson()) {
            $playlist = fractal($playlist, new PlaylistTransformer)
                ->includeTracks()
                ->toArray();

            return response()->json($playlist);
        }

        return view('playlists/show', compact('playlist'));
    }
}
