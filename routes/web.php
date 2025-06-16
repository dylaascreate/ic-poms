<?php

use App\Livewire\ProductIndex;
use App\Livewire\OrderUser;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;


// Main route
Route::get('/', fn () => view('welcome'))->name('home');
// <<<<<<< HEAD
// =======
// Route::get('/about', AboutPage::class)->name('about');
// >>>>>>> ca125c375df63c9f057023727fe992960ecb8298

// Common dashboard route
Route::get('dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin-only route
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', AdminDashboard::class)
    ->name('dashboard');
});


Route::middleware(['auth'])->group(function () { 
    // middleware for authenticated users
    // group all routes that require authentication
    
    // SETTINGS
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // PRODUCTS
    Route::get('product', ProductIndex::class)->name('product');
});

   //ORDER
   Route::get('/order/{productId}', OrderUser::class)->name('order.form');

require __DIR__.'/auth.php';
