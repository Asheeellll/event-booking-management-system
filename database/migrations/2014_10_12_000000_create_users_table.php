<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    /**
     * Run the migrations.
     * This creates the 'users' table in the database.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                          // Auto-increment primary key
            $table->string('name');                                // Full name of the user
            $table->string('email')->unique();                     // Unique email address
            $table->string('phone')->nullable();                   // Optional phone number
            $table->enum('role', ['user', 'admin'])->default('user'); // Role: 'user' or 'admin'
            $table->timestamp('email_verified_at')->nullable();    // Email verification timestamp
            $table->string('password');                            // Hashed password
            $table->rememberToken();                               // For "remember me" login
            $table->timestamps();                                  // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations (drop the table).
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

