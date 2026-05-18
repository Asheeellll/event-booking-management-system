<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRATION: bookings
 * --------------------
 * Records every ticket booking made by a user for an event.
 * - 'tickets' = number of tickets the user booked.
 * - 'total_price' = tickets × event price.
 * - 'status' can be: pending, confirmed, cancelled.
 * - 'notes' = optional special requests from the user.
 */
return new class extends Migration
{
    /**
     * Create the bookings table.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();                                               // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // FK → users
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // FK → events
            $table->integer('tickets')->default(1);                     // Number of tickets booked
            $table->decimal('total_price', 8, 2)->default(0.00);       // Calculated total cost
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // Booking status
            $table->text('notes')->nullable();                          // Optional notes from user
            $table->timestamps();                                       // created_at, updated_at
        });
    }

    /**
     * Drop the bookings table.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
