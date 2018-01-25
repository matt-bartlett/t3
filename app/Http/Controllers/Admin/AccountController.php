<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpotifyAccountRequest;

class AccountController extends Controller
{
    /**
     * @var App\Models\Account
     */
    private $account;

    /**
     * Create a new controller instance.
     *
     * @param App\Models\Account $account
     * @return void
     */
    public function __construct(Account $account)
    {
        $this->middleware('auth');
        $this->account = $account;
    }

    /**
     * Render Spotify accounts
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $accounts = $this->account->paginate(15);

        return view('admin/accounts/index', compact('accounts'));
    }

    /**
     * Render the form to create a Spotify account
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('admin/accounts/create');
    }

    /**
     * Store a Spotify account
     *
     * @param App\Http\Requests\SpotifyAccountRequest $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(SpotifyAccountRequest $request)
    {
        try {
            $account = $this->account->create(
                $request->only('name', 'spotify_account_id')
            );

            return redirect()->route('admin.accounts.index');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Render the form to edit a Spotify account
     *
     * @param integer $id
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $account = $this->account->findOrFail($id);

        return view('admin/accounts/edit', compact('account'));
    }

    /**
     * Update the Spotify account
     *
     * @param App\Http\Requests\SpotifyAccountRequest $request
     * @param integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(SpotifyAccountRequest $request, $id)
    {
        $account = $this->account->findOrFail($id);

        $account->update(
            $request->only('name', 'spotify_user_id')
        );

        return redirect()->route('admin.accounts.index');
    }

    /**
     * Remove the Spotify account
     *
     * @param integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $account = $this->account->findOrFail($id);

        $account->delete();

        return back();
    }
}
