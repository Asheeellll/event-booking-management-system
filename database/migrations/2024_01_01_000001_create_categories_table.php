<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRATION: categories
 * ---------------------
 * Stores event categories (e.g., Music, Sports, Technology).
 * Each event belongs to one category.
 */
return new class extends Migration
{
    public $withinTransaction = false;
    /**
     * Create the categories table.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                           // Primary key
            $table->string('name');                 // Category name (e.g., "Music")
            $table->string('slug')->unique();       // URL-friendly name (e.g., "music")
            $table->timestamps();                   // created_at, updated_at
        });
    }

    /**
     * Drop the categories table.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
