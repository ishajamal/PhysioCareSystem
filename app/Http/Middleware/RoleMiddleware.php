<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if user has the required role
        if ($user->role !== $role) {
            // Redirect to appropriate dashboard based on their actual role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access that page.');
            } elseif ($user->role === 'therapist') {
                return redirect()->route('therapist.dashboard')->with('error', 'You do not have permission to access that page.');
            }
            
            // If role doesn't match any expected role, logout and redirect
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}