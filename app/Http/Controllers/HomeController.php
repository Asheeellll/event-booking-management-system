<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

/**
 * HOME CONTROLLER
 * ---------------
 * Handles the public home page.
 * Shows a welcome banner and a list of upcoming active events.
 */
class HomeController extends Controller
{
    public function index()
    {
        // Fetch the 6 most recent active events for the homepage
        $events = Event::where('status', 'active')
                       ->with('category')
                       ->latest()
                       ->take(6)
                       ->get();

        return view('home', compact('events'));
    }
}
