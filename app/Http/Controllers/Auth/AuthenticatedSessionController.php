<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * AUTHENTICATED SESSION CONTROLLER
 * ----------------------------------
 * Handles user login and logout.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * After login, redirect based on role:
     * - Admin → /admin/dashboard
     * - Regular user → /dashboard
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user (checks email + password)
        $request->authenticate();

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Role-based redirect after login
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Welcome back, Admin!');
        }

        return redirect()->intended(RouteServiceProvider::HOME)
                         ->with('success', 'Welcome back, ' . auth()->user()->name . '!');
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
