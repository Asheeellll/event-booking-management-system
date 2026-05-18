<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

/**
 * ADMIN BOOKING CONTROLLER
 * -------------------------
 * Admin can view all bookings and update their status.
 */
class AdminBookingController extends Controller
{
    /** List all bookings */
    public function index()
    {
        $bookings = Booking::with(['user', 'event'])
                            ->latest()
                            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /** Show a single booking detail */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'event.category']);
        return view('admin.bookings.show', compact('booking'));
    }

    /** Update booking status (pending/confirmed/cancelled) */
    public function updateStatus(Booking $booking, \Illuminate\Http\Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->route('admin.bookings.index')
                         ->with('success', 'Booking status updated to "' . $request->status . '".');
    }
}
