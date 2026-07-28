<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * BOOKING CONTROLLER (User-facing)
 * ---------------------------------
 * Handles enquiry operations for regular users.
 * Internally called "Booking" but presented to users as "Enquiry".
 * All methods require authentication (see routes/web.php).
 */
class BookingController extends Controller
{
    /**
     * Show the enquiry form for a specific event.
     */
    public function create(Event $event)
    {
        // Prevent enquiry for a cancelled event
        if ($event->status === 'cancelled') {
            return redirect()->route('events.show', $event)
                             ->with('error', 'This event has been cancelled.');
        }

        return view('bookings.create', compact('event'));
    }

    /**
     * Save the enquiry to the database.
     */
    public function store(Request $request)
    {
        // Validate the enquiry form
        $validated = $request->validate([
            'event_id'         => ['required', 'exists:events,id'],
            'full_name'        => ['required', 'string', 'max:150'],
            'phone'            => ['required', 'string', 'max:20'],
            'preferred_date'   => ['required', 'date'],
            'expected_guests'  => ['required', 'integer', 'min:1', 'max:100000'],
            'theme_preference' => ['nullable', 'string', 'max:200'],
            'package'          => ['required', 'in:silver,gold,premium'],
            'estimated_budget' => ['required', 'string', 'max:200'],
            'notes' => ['nullable', 'string'],
        ]);

        // Create the enquiry (tickets/total_price default to 0 for backward compatibility)
        Booking::create([
            'user_id'          => auth()->id(),
            'event_id'         => $validated['event_id'],
            'tickets'          => 0,       // backward compatibility
            'total_price'      => 0.00,    // backward compatibility
            'status'           => 'pending',
            'full_name'        => $validated['full_name'],
            'phone'            => $validated['phone'],
            'preferred_date'   => $validated['preferred_date'],
            'expected_guests'  => $validated['expected_guests'],
            'theme_preference' => $validated['theme_preference'] ?? null,
            'package'          => $validated['package'],
            'estimated_budget' => $validated['estimated_budget'],
            'notes'            => $validated['notes'] ?? null,
        ]);

        return redirect()->route('bookings.my')
                         ->with('success', 'Your enquiry has been submitted! Our team will get back to you shortly.');
    }

    /**
     * Show all enquiries for the currently logged-in user.
     */
    public function myBookings()
    {
        $bookings = auth()->user()
                          ->bookings()
                          ->with('event')
                          ->latest()
                          ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }

    /**
     * Withdraw an enquiry (only by the enquiry owner).
     * Route name kept as 'bookings.cancel' for backward compatibility.
     */
    public function cancel(Booking $booking)
    {
        // Security: ensure the enquiry belongs to the logged-in user
        if ($booking->user_id !== auth()->id()) {
            return redirect()->route('bookings.my')
                             ->with('error', 'Unauthorized action.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.my')
                         ->with('success', 'Enquiry withdrawn successfully.');
    }
}
