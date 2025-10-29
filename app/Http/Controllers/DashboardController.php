<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $jiris = auth()->user()->jiris()->orderBy('created_at', 'desc')->limit(4)->get();
        $contacts = auth()->user()->contacts()->orderBy('created_at', 'desc')->limit(4)->get();

        return view('dashboard.index', compact('jiris', 'contacts'));
    }
}
