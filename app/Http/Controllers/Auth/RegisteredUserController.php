<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * REGISTRATION CONTROLLER
 * ------------------------
 * Handles new user registration.
 * - Shows the registration form (create method)
 * - Validates and saves the new user (store method)
 */
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Validates input, creates the user, logs them in, and redirects.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Step 1: Validate all form fields
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone'    => ['nullable', 'string', 'max:20'],          // Phone is optional
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Step 2: Create the new user in the database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,    // Save phone number
            'role'     => 'user',              // Default role is 'user' (not admin)
            'password' => Hash::make($request->password),
        ]);

        // Step 3: Fire the Registered event (for email verification etc.)
        event(new Registered($user));

        // Step 4: Log the user in automatically
        Auth::login($user);

        // Step 5: Redirect to home/dashboard
        return redirect(RouteServiceProvider::HOME);
    }
}
