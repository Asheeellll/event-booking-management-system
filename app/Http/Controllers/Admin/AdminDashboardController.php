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
 * Bookings are presented as "Enquiries" in the UI.
 */
class AdminDashboardController extends Controller
{
    public function index()
    {
        // Enquiry stats for dashboard cards
        $stats = [
            'total_users'       => User::where('role', 'user')->count(),
            'total_events'      => Event::count(),
            'active_events'     => Event::where('status', 'active')->count(),
            'total_enquiries'   => Booking::count(),
            'pending'           => Booking::where('status', 'pending')->count(),
            'approved'          => Booking::where('status', 'confirmed')->count(),   // 'confirmed' = Approved in UI
            'rejected'          => Booking::where('status', 'cancelled')->count(),   // 'cancelled' = Rejected in UI
        ];

        // Latest 5 enquiries for the recent activity table
        $recentBookings = Booking::with(['user', 'event'])
                                  ->latest()
                                  ->take(5)
                                  ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
