<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

// DEBUG: Check what role the user has
    \Log::info('User logged in', [
        'id' => auth()->user()->id,
        'email' => auth()->user()->email,
        'role' => auth()->user()->role,
        'isAdmin' => auth()->user()->isAdmin(),
        'isCustomer' => auth()->user()->isCustomer(),
    ]);


        // Redirect based on user role
        if (auth()->user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if (auth()->user()->isCustomer()) {
            return redirect()->intended(route('customer.dashboard'));
        }

        // Fallback if no role matches
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}