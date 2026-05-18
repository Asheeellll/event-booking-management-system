<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * BOOKING CONTROLLER (User-facing)
 * ---------------------------------
 * Handles booking operations for regular users.
 * All methods require authentication (see routes/web.php).
 */
class BookingController extends Controller
{
    /**
     * Show the booking form for a specific event.
     */
    public function create(Event $event)
    {
        // Prevent booking a cancelled event
        if ($event->status === 'cancelled') {
            return redirect()->route('events.show', $event)
                             ->with('error', 'This event has been cancelled.');
        }

        return view('bookings.create', compact('event'));
    }

    /**
     * Save the booking to the database.
     */
    public function store(Request $request)
    {
        // Validate the booking form
        $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'tickets'  => ['required', 'integer', 'min:1', 'max:10'],
            'notes'    => ['nullable', 'string', 'max:500'],
        ]);

        $event = Event::findOrFail($request->event_id);

        // Check if enough seats are available
        if ($request->tickets > $event->availableSeats()) {
            return back()->with('error', 'Not enough seats available. Only ' . $event->availableSeats() . ' seats left.');
        }

        // Calculate total price
        $totalPrice = $event->price * $request->tickets;

        // Create the booking
        Booking::create([
            'user_id'     => auth()->id(),
            'event_id'    => $request->event_id,
            'tickets'     => $request->tickets,
            'total_price' => $totalPrice,
            'status'      => 'pending',
            'notes'       => $request->notes,
        ]);

        return redirect()->route('bookings.my')
                         ->with('success', 'Booking confirmed! Your booking is pending approval.');
    }

    /**
     * Show all bookings for the currently logged-in user.
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
     * Cancel a booking (only by the booking owner).
     */
    public function cancel(Booking $booking)
    {
        // Security: ensure the booking belongs to the logged-in user
        if ($booking->user_id !== auth()->id()) {
            return redirect()->route('bookings.my')
                             ->with('error', 'Unauthorized action.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.my')
                         ->with('success', 'Booking cancelled successfully.');
    }
}
