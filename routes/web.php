<?php
use App\Models\Product;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AboutusController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\SslCommerzPaymentController;
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


Route::get('frontend.shop-details', function () {
    return view('frontend.shop-details');
})->name('frontend.shop-details');


Route::get('/', function () {

    // Featured products (for Featured Section)
    $featuredProducts = Product::with('images')
        ->where('status', 'active')
        ->where('is_featured', true)
        ->latest()
        ->take(8)
        ->get();

    // Normal latest products (if you still need)
    $products = Product::with('images')
        ->where('status', 'active')
        ->latest()
        ->take(8)
        ->get();

    return view('layouts.index', compact('featuredProducts', 'products'));
})->name('home');



// Route::get('/dashboard', function () {
//     return view('customer.dashboard');
// })->name('customer.dashboard');
Route::get('admin/products/fix-stock-status', 
    [ProductController::class, 'fixStockStatus'])
    ->name('admin.products.fix-stock-status');
// Contact routes (public)
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])
     ->name('admin.products.index');


// About us route (public)


// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/checkout-success', [CheckoutController::class, 'success'])->name('checkout.success');
    // Profile routes (for all authenticated users)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/cart',              [CartController::class, 'index'])->name('cart.index');
    
    Route::patch('/cart/{cart}',     [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}',    [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart',           [CartController::class, 'clear'])->name('cart.clear');

// routes/web.php — auth middleware এর ভেতরে
Route::post('/reviews/{product}', [App\Http\Controllers\ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])
    ->name('reviews.destroy')
    ->middleware('auth');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'userProfileUpdate'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
    
     // Customer Routes
    Route::middleware(['customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
        

    Route::get('/order', [CustomerController::class, 'order'])->name('order');
    Route::get('/orders/{id}', [CustomerController::class, 'orderDetails'])->name('order.details');
    // Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');

    });
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

     // Order Management
    Route::get('/orders',                    [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',               [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status',       [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{id}/payment',      [AdminOrderController::class, 'updatePayment'])->name('orders.payment');
  Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

Route::resource('products', ProductController::class);
    Route::delete('products/{product}/delete-image/{image}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::get('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');


// Admin Settings Routes
Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('settings.general');
Route::post('/settings/profile', [App\Http\Controllers\Admin\SettingsController::class, 'updateProfile'])->name('settings.profile');
Route::post('/settings/security', [App\Http\Controllers\Admin\SettingsController::class, 'updateSecurity'])->name('settings.security');
Route::post('/settings/notifications', [App\Http\Controllers\Admin\SettingsController::class, 'updateNotifications'])->name('settings.notifications');

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/aboutus', [AboutusController::class, 'index'])->name('admin.Aboutus');

        // Category Routes
        Route::resource('categories', CategoryController::class);
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');


        
         Route::post('/products', [ProductController::class, 'store'])->name('products.store');
       // About Us Management (admin side)
        Route::get('/aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
        Route::get('/aboutus/edit', [AboutusController::class, 'edit'])->name('aboutus.edit');
        Route::put('/aboutus/update', [AboutusController::class, 'update'])->name('aboutus.update');

    
    
    });
    


Route::get('/shop', [ShopController::class, 'index'])->name('frontend.shop');

// PUBLIC shop routes — place near the top with other public routes

Route::get('/admin/brands', [BrandController::class, 'index'])->name('admin.brands.index');

 Route::post('/cart',             [CartController::class, 'store'])->name('cart.store');
Route::get('/cache_clear',function(){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success','Cache cleard!!');
});

Route::get('/shop/{slug}',            [ShopController::class, 'show'])->name('shop.show');
Route::post('/shop/{slug}/review',    [ShopController::class, 'review'])->name('shop.review')->middleware('auth');
Route::get('/shop/quick-view/{id}',   [ShopController::class, 'quickView'])->name('shop.quickView');


// SSLCOMMERZ Start
Route::get('/Checkout', [SslCommerzPaymentController::class, 'Checkout.index']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::match(['get', 'post'], '/success', [SslCommerzPaymentController::class, 'success']);
Route::match(['get', 'post'], '/fail', [SslCommerzPaymentController::class, 'fail']);
Route::match(['get', 'post'], '/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
Route::get('/storage_link',function(){
    Artisan::call('storage:link');
    return redirect()->back()->with('success','Storage link complete!!');
    // return "Storage Linked";
});

require __DIR__.'/auth.php';