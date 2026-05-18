<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * ADMIN USER CONTROLLER
 * ----------------------
 * Admin can view and manage all registered users.
 * Admins cannot delete themselves.
 */
class AdminUserController extends Controller
{
    /** List all regular users */
    public function index()
    {
        $users = User::where('role', 'user')
                     ->withCount('bookings')
                     ->latest()
                     ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /** Show a single user's profile and bookings */
    public function show(User $user)
    {
        $bookings = $user->bookings()->with('event')->latest()->get();
        return view('admin.users.show', compact('user', 'bookings'));
    }

    /** Delete a user (and their bookings via cascade) */
    public function destroy(User $user)
    {
        // Prevent deleting admin accounts
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Cannot delete admin accounts.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
