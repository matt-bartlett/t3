<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Account;
use App\Models\Playlist;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistRequest;
use App\T3\Services\CreatePlaylistService;
use App\Http\Requests\SpotifyPlaylistRequest;

class PlaylistController extends Controller
{
    /**
     * @var App\Models\Playlist
     */
    private $playlist;

    /**
     * @var App\Models\Account
     */
    private $account;

    /**
     * Create a new controller instance.
     *
     * @param App\Models\Playlist $playlist
     * @param App\Models\Account $account
     * @return void
     */
    public function __construct(Account $account, Playlist $playlist)
    {
        $this->middleware('auth');
        $this->account = $account;
        $this->playlist = $playlist;
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
        $accounts = $this->account->get();

        return view('admin/playlists/create', compact('accounts'));
    }

    /**
     * Store a new Playlist
     *
     * @param App\Http\Requests\SpotifyPlaylistRequest $request
     * @param App\T3\Services\CreatePlaylistService $service
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(SpotifyPlaylistRequest $request, CreatePlaylistService $service)
    {
        try {
            $playlist = $service->make($request);

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
