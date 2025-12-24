<div class="flex items-center space-x-4">

    <!-- Notification Icon -->
    <div class="relative cursor-pointer">
        <span class="absolute -right-1 -top-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">3</span>
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.702 18 14.172V11c0-3.866-3.134-7-7-7S4 7.134 4 11v3.172c0 .53-.21 1.038-.595 1.423L2 17h5m8 0a3 3 0 11-6 0h6z" />
        </svg>
    </div>

    <!-- Profile Dropdown -->
    <div class="relative group cursor-pointer">
        <div class="flex items-center space-x-2">
            
            <!-- Avatar -->
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                class="w-10 h-10 rounded-full border" alt="profile">

            <div>
                <p class="font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ ucfirst(auth()->user()->role) }}
                </p>
            </div>

            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <!-- Dropdown -->
        <div
            class="hidden group-hover:block absolute right-0 bg-white shadow-lg rounded-lg w-48 mt-2">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                Profile Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
        </div>
    </div>

</div>
