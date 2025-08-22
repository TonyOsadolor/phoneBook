<?php

use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ContactComponent;
use App\Livewire\BinComponent;

Route::get('/', function () {

    if (Auth::user()) {
        return redirect('/dashboard');
    }

    return redirect('/login');

})->name('home');

// Dashboard
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', ContactComponent::class)->name('dashboard');
});

Route::get('/bin', BinComponent::class)->name('bin');

// Routes to Service
Route::prefix('settings')->middleware(['auth'])->group(function () {
    Route::get('/profile', Profile::class)->name('settings.profile');
    Route::get('/password', Password::class)->name('settings.password');
    Route::get('/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
