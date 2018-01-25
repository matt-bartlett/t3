<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use App\Models\Playlist;
use App\T3\Spotify\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistRequest;
use App\Http\Requests\SpotifyPlaylistRequest;
use App\T3\Spotify\Transformers\PlaylistTransformer;

class PlaylistController extends Controller
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
     * Create a new controller instance.
     *
     * @param App\Models\Playlist $playlist
     * @param App\T3\Spotiy\Client $spotify
     * @return void
     */
    public function __construct(Playlist $playlist, Client $spotify)
    {
        $this->middleware('auth');
        $this->playlist = $playlist;
        $this->spotify = $spotify;
    }

    /**
     * Render admin dashboard
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $playlists = $this->playlist->latest()->paginate(15);

        return view('admin/playlists/index', compact('playlists'));
    }

    /**
     * Render the form to fetch a playlist from Spotify
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('admin/playlists/create');
    }

    /**
     * Store a new Playlist
     *
     * @param App\Http\Requests\SpotifyPlaylistRequest $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(SpotifyPlaylistRequest $request)
    {
        try {
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

            return redirect()->route('admin.playlists.index');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Render the form to edit a Playlist
     *
     * @param integer $id
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $playlist = $this->playlist->findOrFail($id);

        return view('admin/playlists/edit', compact('playlist'));
    }

    /**
     * Update the Playlist
     *
     * @param App\Http\Requests\PlaylistRequest $request
     * @param integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(PlaylistRequest $request, $id)
    {
        $playlist = $this->playlist->findOrFail($id);

        $playlist->update([
            'name' => $request->get('name')
        ]);

        return redirect()->route('admin.playlists.index');
    }
    /**
     * Remove the Playlist
     *
     * @param integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $playlist = $this->playlist->findOrFail($id);

        $playlist->delete();

        return back();
    }
}
