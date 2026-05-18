<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * EVENT MODEL
 * -----------
 * Represents a single event in the system.
 * - Belongs to a Category (type of event).
 * - Belongs to a User (the admin who created it).
 * - Can have many Bookings.
 */
class Event extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     */
    protected $fillable = [
        'category_id',   // Foreign key → categories table
        'user_id',       // Foreign key → users table (admin creator)
        'title',         // Event title
        'description',   // Full description
        'date',          // Event date
        'time',          // Event time
        'venue',         // Location
        'capacity',      // Max tickets
        'price',         // Ticket price
        'image',         // Image filename
        'status',        // 'active' or 'cancelled'
    ];

    /**
     * Field type casting.
     */
    protected $casts = [
        'date'  => 'date',
        'price' => 'decimal:2',
    ];

    // ─────────────────────────────────────────
    // RELATIONSHIPS
    // ─────────────────────────────────────────

    /**
     * An event belongs to a category.
     * Usage: $event->category->name
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * An event belongs to a user (the creator/admin).
     * Usage: $event->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An event has many bookings.
     * Usage: $event->bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ─────────────────────────────────────────
    // HELPER METHODS
    // ─────────────────────────────────────────

    /**
     * Get how many tickets have been booked so far.
     * Usage: $event->bookedTickets()
     */
    public function bookedTickets(): int
    {
        return $this->bookings()
                    ->whereIn('status', ['confirmed', 'pending'])
                    ->sum('tickets');
    }

    /**
     * Get remaining available seats.
     * Usage: $event->availableSeats()
     */
    public function availableSeats(): int
    {
        return $this->capacity - $this->bookedTickets();
    }

    /**
     * Check if the event is free.
     * Usage: $event->isFree()
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }
}
