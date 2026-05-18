<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;

/**
 * ADMIN DASHBOARD CONTROLLER
 * ---------------------------
 * Shows the admin overview with site-wide statistics.
 */
class AdminDashboardController extends Controller
{
    public function index()
    {
        // Collect stats to display on the admin dashboard cards
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_events'   => Event::count(),
            'active_events'  => Event::where('status', 'active')->count(),
            'total_bookings' => Booking::count(),
            'pending'        => Booking::where('status', 'pending')->count(),
            'confirmed'      => Booking::where('status', 'confirmed')->count(),
            'revenue'        => Booking::where('status', 'confirmed')->sum('total_price'),
        ];

        // Latest 5 bookings for the recent activity table
        $recentBookings = Booking::with(['user', 'event'])
                                  ->latest()
                                  ->take(5)
                                  ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
