<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Render admin dashboard
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $user = \Auth::user();

        return view('admin/index', compact('user'));
    }
}
