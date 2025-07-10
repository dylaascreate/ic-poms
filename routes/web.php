<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\HomeController;

use App\Livewire\Auth\Login;
use App\Livewire\ProductIndex;
use App\Livewire\OrderUser;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use App\Livewire\ManageProduct;
use App\Livewire\ManageCustomer;
use App\Livewire\ManageStaff;
use App\Livewire\Admin\Dashboard as AdminDashboard;

// ===============================
// Public Routes
// ===============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/order/{productId}', OrderUser::class)->name('order.form');
Route::get('/login', Login::class)->name('login');

// Order tracking (AJAX)
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

// ===============================
// Authenticated Routes
// ===============================
Route::middleware(['auth'])->group(function () {

    // Dashboard routing based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->middleware(['verified'])->name('views.dashboard');

    // Admin dashboard
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    });

    // Settings
    Route::redirect('/settings', '/settings/profile');
    Route::get('/settings/profile', Profile::class)->name('settings.profile');
    Route::get('/settings/password', Password::class)->name('settings.password');
    Route::get('/settings/appearance', Appearance::class)->name('settings.appearance');

    // Management (based on roles)
    Route::get('/product', ProductIndex::class)->name('product');
    Route::get('/manage-product', ManageProduct::class)->name('manage-product');
    Route::get('/manage-customer', ManageCustomer::class)->name('manage-customer');
    Route::get('/manage-staff', ManageStaff::class)->name('manage-staff');
    Route::get('/manage-order', \App\Livewire\ManageOrder::class)->name('manage-order');

    // Routes for users with 'marketing' role only (via Gate)
    Route::middleware(['can:manage-marketing'])->group(function () {
        Route::resource('promotions', PromotionController::class)->except(['create', 'show']);
        Route::resource('products', ProductController::class)->except(['create', 'show']);
        Route::resource('teams', TeamController::class)->except(['create', 'show']);
    });
});

// Laravel Breeze/Fortify/Auth routes
require __DIR__.'/auth.php';
