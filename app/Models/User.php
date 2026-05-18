<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * USER MODEL
 * ----------
 * Represents a registered user of the system.
 * Users can have role: 'user' (default) or 'admin'.
 * A user can make many bookings.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass-assignable fields.
     * These are the fields we allow to be set via create() or update().
     */
    protected $fillable = [
        'name',
        'email',
        'phone',    // Added: user's phone number
        'role',     // Added: 'user' or 'admin'
        'password',
    ];

    /**
     * Hidden fields (not exposed in JSON responses).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Field type casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ─────────────────────────────────────────
    // RELATIONSHIPS
    // ─────────────────────────────────────────

    /**
     * A user can have many bookings.
     * Usage: $user->bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ─────────────────────────────────────────
    // HELPER METHODS
    // ─────────────────────────────────────────

    /**
     * Check if the user is an admin.
     * Usage: if (auth()->user()->isAdmin()) { ... }
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
