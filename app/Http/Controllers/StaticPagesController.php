<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    /**
     * Show the home page.
     *
     * @return Application|Factory|View
     */
    public function home(): Factory|View|Application
    {
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(30);
        }

        return view('static_pages/home', compact('feed_items'));
    }

    /**
     * Show the help page.
     *
     * @return Application|Factory|View
     */
    public function help(): Factory|View|Application
    {
        return view('static_pages/help');
    }

    /**
     * Show the about page.
     *
     * @return Application|Factory|View
     */
    public function about(): Factory|View|Application
    {
        return view('static_pages/about');
    }
}
