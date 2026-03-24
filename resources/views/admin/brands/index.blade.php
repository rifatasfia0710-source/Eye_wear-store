@extends('admin.layouts.app')

@section('title', 'Brands')
@section('page-title', 'Brands')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manage Brands</h1>
        <p class="text-gray-600">Manage eyewear brands for your store</p>
    </div>
    <a href="{{ route('admin.brands.create') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
        <i class="fas fa-plus mr-2"></i> Add New Brand
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Brands</p>
                <p class="text-2xl font-bold">{{ $brands->total() }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-tags text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Active Brands</p>
                <p class="text-2xl font-bold">{{ \App\Models\Brand::where('is_active', true)->count() }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Inactive Brands</p>
                <p class="text-2xl font-bold">{{ \App\Models\Brand::where('is_active', false)->count() }}</p>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <i class="fas fa-times-circle text-gray-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Brands Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">#{{ $brand->id }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $brand->name }}</div>
                        @if($brand->description)
                            <div class="text-sm text-gray-500">{{ Str::limit($brand->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $brand->slug }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">{{ $brand->products_count ?? 0 }} products</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded {{ $brand->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium space-x-2">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure? This will fail if brand has products.')"
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-tags text-4xl mb-4 opacity-50"></i>
                        <p class="text-lg">No brands found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($brands->hasPages())
    <div class="px-6 py-4 bg-gray-50">
        {{ $brands->links() }}
    </div>
    @endif
</div>
@endsection