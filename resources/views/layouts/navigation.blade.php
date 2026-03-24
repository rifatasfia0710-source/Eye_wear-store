<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

@auth
    @if(auth()->user()->isAdmin())
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Admin Dashboard') }}
        </x-nav-link>
    @endif

    @if(auth()->user()->isCustomer())
        <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')">
            {{ __('My Dashboard') }}
        </x-nav-link>
    @endif
         {{-- 🛒 Cart Badge (Tailwind, customers only) --}}
                    @if(auth()->user()->isCustomer())
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                        @endphp
                        <a href="{{ route('cart.index') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                            🛒 Cart
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endif
    <!-- Logout button -->
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="text-gray-700 hover:text-gray-900 px-3 py-2">
            Logout
        </button>
    </form>
@endauth

@guest
    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">Login</x-nav-link>
    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">Register</x-nav-link>
@endguest

</nav>