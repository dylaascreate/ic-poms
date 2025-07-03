<?php

use App\Livewire\ProductIndex;
use App\Livewire\OrderUser;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
// use App\Livewire\Auth\UserDashboard as UserDashboard;
use App\Livewire\ManageProduct;
use App\Livewire\ManageCustomer;
use App\Livewire\Auth\Login;
use App\Livewire\ManageStaff;


// Main route
Route::get('/', fn () => view('welcome'))->name('home');

// Login route 
Route::get('/login', Login::class)->name('login');

// Common dashboard route
Route::get('dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('views.dashboard');

// Admin-only route
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('dashboard');
});

//user dashboard route
// Route::middleware(['auth', 'verified'])
// ->get('/dashboard', UserDashboard::class)->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () { 
    // SETTINGS
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // PRODUCTS
    Route::get('product', ProductIndex::class)->name('product');
    Route::get('manage-product', ManageProduct::class)->name('manage-product');

    // USER
    Route::get('manage-customer', ManageCustomer::class)->name('manage-customer');
    Route::get('manage-staff', ManageStaff::class)->name('manage-staff');

    // ORDERS
    Route::get('manage-order', \App\Livewire\ManageOrder::class)->name('manage-order');
});

// ORDER (public route)
Route::get('/order/{productId}', OrderUser::class)->name('order.form');


require __DIR__.'/auth.php';


// User dashboard route
// Route::middleware(['auth'])->group(function () {
//     Route::get('/user/dashboard', \App\Livewire\Auth\UserDashboard::class)->name('user.dashboard');
// });

// Order tracking route
Route::get('/track-order', function(Request $request) {
    $order = Order::where('no_order', $request->order_id)->first();
    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }
    return response()->json([
        'no_order' => $order->no_order,
        'status' => $order->status,
        'description' => $order->description,
        'price' => number_format($order->price, 2),
    ]);
});

