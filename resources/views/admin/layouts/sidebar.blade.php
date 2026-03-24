<aside class="w-64 bg-gray-900 text-white flex-shrink-0">
    <div class="p-6">
        <h1 class="text-2xl font-bold">Eyewear Admin</h1>
    </div>
    
    <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
            <i class="fas fa-home w-5"></i>
            <span class="ml-3">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
            <i class="fas fa-glasses w-5"></i>
            <span class="ml-3">Products</span>
        </a>
        
        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
            <i class="fas fa-th-large w-5"></i>
            <span class="ml-3">Categories</span>
        </a>
        
        <a href="{{ route('admin.brands.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.brands.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
            <i class="fas fa-tags w-5"></i>
            <span class="ml-3">Brands</span>
        </a>
        
        <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-800">
            <i class="fas fa-shopping-cart w-5"></i>
            <span class="ml-3">Orders</span>
        </a>
        
        <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-800">
            <i class="fas fa-users w-5"></i>
            <span class="ml-3">Customers</span>
        </a>
        
        <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-800">
            <i class="fas fa-chart-bar w-5"></i>
            <span class="ml-3">Reports</span>
        </a>
        
        <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-800">
            <i class="fas fa-cog w-5"></i>
            <span class="ml-3">Settings</span>
        </a>
    </nav>
</aside>