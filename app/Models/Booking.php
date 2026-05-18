<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BOOKING MODEL
 * -------------
 * Represents a ticket booking made by a user for an event.
 * - Belongs to a User (who made the booking).
 * - Belongs to an Event (what was booked).
 */
class Booking extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     */
    protected $fillable = [
        'user_id',      // Foreign key → users table
        'event_id',     // Foreign key → events table
        'tickets',      // Number of tickets booked
        'total_price',  // Calculated: tickets × event price
        'status',       // 'pending', 'confirmed', or 'cancelled'
        'notes',        // Optional special request from user
    ];

    // ─────────────────────────────────────────
    // RELATIONSHIPS
    // ─────────────────────────────────────────

    /**
     * A booking belongs to a user.
     * Usage: $booking->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A booking belongs to an event.
     * Usage: $booking->event->title
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
