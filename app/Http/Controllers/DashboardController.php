<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * USER DASHBOARD CONTROLLER
 * --------------------------
 * Shows the logged-in user's personal dashboard.
 * Displays enquiry stats and recent enquiries.
 * Internal model is Booking; UI labels say "Enquiry".
 */
class DashboardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $bookings = $user->bookings()->with('event')->latest()->get();

        // Stats for the dashboard cards (UI labels: Approved / Rejected)
        $stats = [
            'total'    => $bookings->count(),
            'approved' => $bookings->where('status', 'confirmed')->count(),  // 'confirmed' = Approved in UI
            'pending'  => $bookings->where('status', 'pending')->count(),
            'rejected' => $bookings->where('status', 'cancelled')->count(),  // 'cancelled' = Rejected in UI
        ];

        return view('dashboard', compact('bookings', 'stats'));
    }
}
