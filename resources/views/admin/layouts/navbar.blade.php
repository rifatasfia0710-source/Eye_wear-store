<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <button id="sidebarToggle" class="text-gray-500 focus:outline-none lg:hidden">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h2 class="text-2xl font-semibold text-gray-800 ml-4">@yield('page-title', 'Dashboard')</h2>
        </div>
        
        <div class="flex items-center space-x-4">
            <!-- View Store -->
            <a href="{{ route('home') }}" target="_blank" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-external-link-alt"></i>
                <span class="ml-2 hidden md:inline">View Store</span>
            </a>
            
            <!-- Notifications -->
            <button class="relative text-gray-600 hover:text-gray-800">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
            </button>
            
            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff" 
                         alt="Avatar" 
                         class="w-8 h-8 rounded-full">
                    <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down text-sm"></i>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-user w-5"></i> Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-cog w-5"></i> Settings
                    </a>
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt w-5"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush