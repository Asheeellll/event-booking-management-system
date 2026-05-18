<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * CATEGORY MODEL
 * --------------
 * Represents an event category (e.g., Music, Sports, Tech).
 * A category can have many events.
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     */
    protected $fillable = [
        'name',   // Display name, e.g. "Music"
        'slug',   // URL-friendly name, e.g. "music"
    ];

    // ─────────────────────────────────────────
    // RELATIONSHIPS
    // ─────────────────────────────────────────

    /**
     * A category has many events.
     * Usage: $category->events
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
