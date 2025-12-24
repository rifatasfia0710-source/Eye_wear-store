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