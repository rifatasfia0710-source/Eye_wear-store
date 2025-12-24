<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Check if user is logged in AND is admin
    //     if (!auth()->check() || !auth()->user()->isAdmin()) {
    //         abort(403, 'Unauthorized access.');
    //     }

    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is admin
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If not admin, redirect to customer dashboard or appropriate page
        return redirect()->route('customer.dashboard')
            ->with('error', 'You do not have admin access.');
    }
}
