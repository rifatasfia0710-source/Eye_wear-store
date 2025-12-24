<?php
use App\Models\Product;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AboutusController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
// Public Routes

Route::get('/faq', function () {
    return view('faq');
})->name('faq');
Route::get('/returns', function () {
    return view('returns');
})->name('returns');
Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

Route::get('/delivery-policy', function () {
    return view('delivery-policy');
})->name('delivery-policy');

Route::get('/shop-details', function () {
    return view('shop-details');
})->name('shop-details');

Route::get('/', function () {
    $products = Product::with('productImages')
        ->where('status', 'active')
        ->latest()
        ->take(8)
        ->get();
    return view('layouts.index', compact('products'));
})->name('home');

// Route::get('/shop', function () {
//     return view('frontend.shop');
// });
Route::get('/dashboard', function () {
    return view('customer.dashboard');
})->name('customer.dashboard');

// Contact routes (public)
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// About us route (public)
// Route::get('/aboutus', [AboutusController::class, 'index'])->name('aboutus');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Profile routes (for all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/aboutus', [AboutusController::class, 'index'])->name('admin.Aboutus');

        // Category Routes
        Route::resource('categories', CategoryController::class);
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

        // Product Routes
        Route::resource('products', ProductController::class);
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
        Route::get('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::delete('products/{product}/delete-image/{image}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
        // Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
       // About Us Management (admin side)
        Route::get('/aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
        Route::get('/aboutus/edit', [AboutusController::class, 'edit'])->name('aboutus.edit');
        Route::put('/aboutus/update', [AboutusController::class, 'update'])->name('aboutus.update');


    //   Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    //     Route::get('/products/{slug}', [ShopController::class, 'show'])->name('products.show');
    //     Route::get('/products/{id}/quick-view', [ShopController::class, 'quickView']);

    });
    
    // Customer Routes
    Route::middleware(['customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    });
});

Route::get('/shop', [ShopController::class, 'index'])->name('frontend.shop');
//  Route::get('/products/{slug}', [ShopController::class, 'show'])->name('products.show');



Route::get('/cache_clear',function(){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    // Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success','Cache cleard!!');
});

Route::get('/storage_link',function(){
    Artisan::call('storage:link');
    return redirect()->back()->with('success','Storage link complete!!');
    // return "Storage Linked";
});

require __DIR__.'/auth.php';