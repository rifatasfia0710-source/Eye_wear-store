<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Check if user is logged in AND is a customer
    //     if (!auth()->check() || !auth()->user()->isCustomer()) {
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

        // Check if user is customer
        if (Auth::user()->role === 'customer') {
            return $next($request);
        }

        // If not customer, redirect to admin dashboard
        return redirect()->route('admin.dashboard')
            ->with('error', 'You do not have customer access.');
    }
}
