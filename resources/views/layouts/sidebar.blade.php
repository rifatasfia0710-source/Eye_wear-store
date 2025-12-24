

<x-app-layout>
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main content --}}
        <div class="flex-1 p-6 bg-gray-100">
            <div class="max-w-7xl mx-auto">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800"></h2>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Logout</button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-blue-100 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold text-blue-800">Total Customers</h4>
                        <p class="text-3xl font-bold">{{ $totalCustomers }}</p>
                    </div>

                    <div class="bg-green-100 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold text-green-800">Total Products</h4>
                        <p class="text-3xl font-bold">0</p>
                    </div>

                    <div class="bg-yellow-100 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold text-yellow-800">Total Orders</h4>
                        <p class="text-3xl font-bold">0</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
