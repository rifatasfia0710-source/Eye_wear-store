<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Cart;
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

    // 🛒 Guest cart → DB cart sync (ONLY for customers)
    if (auth()->user()->isCustomer() && session()->has('cart')) {

        foreach (session('cart') as $item) {
            Cart::updateOrCreate(
                [
                    'user_id'     => Auth::id(),
                    'product_id'  => $item['product_id'],
                    'lens_type'   => $item['lens_type'],
                    'frame_color' => $item['frame_color'],
                ],
                [
                    'quantity'  => \DB::raw('quantity + '.$item['quantity']),
                    'sph_left'  => $item['sph_left'],
                    'sph_right' => $item['sph_right'],
                ]
            );
        }

        session()->forget('cart');
    }

    // 🔐 Role based redirect (LAST)
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->isCustomer()) {
        return redirect()->route('customer.dashboard');
    }

    // fallback
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

        // return redirect('/');
        return redirect()->intended(route('cart.index'));
    }
}