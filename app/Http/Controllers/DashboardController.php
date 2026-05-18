<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * USER DASHBOARD CONTROLLER
 * --------------------------
 * Shows the logged-in user's personal dashboard.
 * Displays booking stats and recent bookings.
 */
class DashboardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $bookings = $user->bookings()->with('event')->latest()->get();

        // Stats for the dashboard cards
        $stats = [
            'total'     => $bookings->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'pending'   => $bookings->where('status', 'pending')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        return view('dashboard', compact('bookings', 'stats'));
    }
}
