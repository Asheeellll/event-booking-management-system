<?php

use Illuminate\Support\Facades\Route;

// ─── Controllers ─────────────────────────────────────────────────────────────
use App\Http\Controllers\AIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes — Event Booking Management System
|--------------------------------------------------------------------------
|
| Routes are organized into 3 groups:
| 1. Public routes (no login required)
| 2. User routes  (login required)
| 3. Admin routes (login + admin role required)
|
*/

// ─────────────────────────────────────────────────────────────────────────────
// GROUP 1: PUBLIC ROUTES
// These routes are accessible by everyone (logged in or not)
// ─────────────────────────────────────────────────────────────────────────────

// Home page — shows featured events, hero banner
Route::get('/', [HomeController::class, 'index'])->name('home');

// Event listing — browse all available events
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Single event detail page
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');


// ─────────────────────────────────────────────────────────────────────────────
// GROUP 2: USER ROUTES (requires login)
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware(['auth'])->group(function () {

    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AI Event Planner
    Route::post('/ai/event-plan', [AIController::class, 'generate'])
        ->name('ai.event.plan');

    // Booking: Show form to book a specific event
    Route::get('/bookings/create/{event}', [BookingController::class, 'create'])->name('bookings.create');

    // Booking: Save the booking to database
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Booking: List all bookings for the logged-in user
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');

    // Booking: Cancel a booking
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

});

// ─────────────────────────────────────────────────────────────────────────────
// GROUP 3: ADMIN ROUTES (requires login + admin role)
// All routes here are prefixed with /admin
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin: Event CRUD
    Route::resource('events', AdminEventController::class);

    // Admin: Booking Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');

    // Admin: User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

});

// ─────────────────────────────────────────────────────────────────────────────
// AUTH ROUTES (provided by Laravel Breeze)
// Includes: login, register, logout, password reset
// ─────────────────────────────────────────────────────────────────────────────
require __DIR__ . '/auth.php';
