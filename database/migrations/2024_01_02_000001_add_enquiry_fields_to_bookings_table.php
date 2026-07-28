<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRATION: add_enquiry_fields_to_bookings_table
 * ------------------------------------------------
 * Adds event enquiry-specific fields to the existing bookings table.
 * The original columns (tickets, total_price, notes, status) are kept
 * for backward compatibility and are NOT removed.
 *
 * New columns:
 *   - full_name        : Customer's full name as entered in the enquiry form
 *   - phone            : Customer's contact phone number
 *   - preferred_date   : Customer's preferred event date
 *   - expected_guests  : Estimated number of guests
 *   - theme_preference : Theme or decoration preference
 *   - package          : Selected package tier (silver / gold / premium)
 *   - estimated_budget : Customer's stated budget range (free text)
 */
return new class extends Migration
{
    public $withinTransaction = false;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('notes');
            $table->string('phone')->nullable()->after('full_name');
            $table->date('preferred_date')->nullable()->after('phone');
            $table->integer('expected_guests')->nullable()->after('preferred_date');
            $table->string('theme_preference')->nullable()->after('expected_guests');
            $table->enum('package', ['silver', 'gold', 'premium'])->nullable()->after('theme_preference');
            $table->string('estimated_budget')->nullable()->after('package');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'phone',
                'preferred_date',
                'expected_guests',
                'theme_preference',
                'package',
                'estimated_budget',
            ]);
        });
    }
};
