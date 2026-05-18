<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ADMIN MIDDLEWARE
 * ----------------
 * This middleware protects admin routes.
 * It checks if the logged-in user has the 'admin' role.
 * If not, they are redirected to the home page with an error message.
 *
 * Usage: Applied to all routes inside the /admin prefix group.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check 1: Is the user logged in?
        if (!auth()->check()) {
            return redirect()->route('login')
                             ->with('error', 'Please login to continue.');
        }

        // Check 2: Is the logged-in user an admin?
        if (!auth()->user()->isAdmin()) {
            // If not admin, redirect to home with a warning message
            return redirect()->route('home')
                             ->with('error', 'Access denied. You do not have admin privileges.');
        }

        // User is authenticated and is an admin — allow the request
        return $next($request);
    }
}
