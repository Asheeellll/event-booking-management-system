<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRATION: events
 * -----------------
 * Stores all events in the system.
 * - Each event belongs to a category.
 * - Each event is created by an admin (user_id).
 * - 'capacity' tracks how many tickets are available.
 * - 'status' can be 'active' or 'cancelled'.
 */
return new class extends Migration
{
    public $withinTransaction = false;
    /**
     * Create the events table.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();                                               // Primary key
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // FK → categories
            $table->foreignId('user_id')->constrained()->onDelete('cascade');     // FK → users (admin who created it)
            $table->string('title');                                    // Event name
            $table->text('description');                                // Full event description
            $table->date('date');                                       // Event date (YYYY-MM-DD)
            $table->time('time');                                       // Event start time
            $table->string('venue');                                    // Location/venue name
            $table->integer('capacity');                                // Max tickets available
            $table->decimal('price', 8, 2)->default(0.00);             // Ticket price (0 = free)
            $table->string('image')->nullable();                        // Optional event image path
            $table->enum('status', ['active', 'cancelled'])->default('active'); // Event status
            $table->timestamps();                                       // created_at, updated_at
        });
    }

    /**
     * Drop the events table.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
