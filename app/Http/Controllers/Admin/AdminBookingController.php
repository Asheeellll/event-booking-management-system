<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

/**
 * ADMIN BOOKING CONTROLLER
 * -------------------------
 * Admin can view all enquiries and update their status.
 * Internally the model is "Booking"; UI calls them "Enquiries".
 */
class AdminBookingController extends Controller
{
    /**
     * List all enquiries with optional search and status filter.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'event'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by customer name, email, or event title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                                                      ->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('event', fn ($e) => $e->where('title', 'like', "%{$search}%"));
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show a single enquiry detail.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'event.category']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update enquiry status (pending / confirmed / cancelled).
     * Status values remain as-is in DB; UI labels differ.
     */
    public function updateStatus(Booking $booking, Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $booking->update(['status' => $request->status]);

        // Map DB values to user-friendly labels for the flash message
        $labels = [
            'pending'   => 'Pending',
            'confirmed' => 'Approved',
            'cancelled' => 'Rejected',
        ];
        $label = $labels[$request->status] ?? $request->status;

        return redirect()->route('admin.bookings.index')
                         ->with('success', 'Enquiry status updated to "' . $label . '".');
    }
}
