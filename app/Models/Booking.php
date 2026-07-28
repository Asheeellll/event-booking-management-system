<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BOOKING MODEL (used internally; presented to users as "Enquiry")
 * ----------------------------------------------------------------
 * Represents an event enquiry submitted by a user.
 * - Belongs to a User (who submitted the enquiry).
 * - Belongs to an Event (the event being enquired about).
 *
 * Original booking columns (tickets, total_price) are retained
 * for backward compatibility but are no longer used in the UI.
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
        'tickets',      // Kept for backward compatibility (not used in enquiry UI)
        'total_price',  // Kept for backward compatibility (not used in enquiry UI)
        'status',       // 'pending', 'confirmed', or 'cancelled'
        'notes',        // Special requirements from the customer

        // ── Enquiry fields (added via migration 2024_01_02_000001) ──
        'full_name',         // Customer's full name from enquiry form
        'phone',             // Customer's contact number
        'preferred_date',    // Preferred event date
        'expected_guests',   // Estimated guest count
        'theme_preference',  // Theme/decoration preference
        'package',           // Package tier: silver | gold | premium
        'estimated_budget',  // Customer's stated budget range
    ];

    /**
     * Field type casting.
     */
    protected $casts = [
        'preferred_date' => 'date',
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
