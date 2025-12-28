<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/ngos-posts', function () {
    return view('ngos-posts');
})->name('ngos-posts');

Route::get('/individual-posts', function () {
    return view('individual-posts');
})->name('individual-posts');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/join-staff', function () {
    return view('join-staff');
})->name('join-staff');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Staff Routes
Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
});

// User Routes (those who need help)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/eligibility-forum', function () {
        return view('users.eligibility-forum');
    })->name('eligibility-forum');
});

// NGO Routes
Route::middleware(['auth'])->prefix('ngo')->name('ngo.')->group(function () {
    Route::get('/post-request', function () {
        return view('ngo.post-request');
    })->name('post-request');
});

// Donor Routes
Route::middleware(['auth'])->prefix('donor')->name('donor.')->group(function () {
    Route::get('/donations', function () {
        return view('donors.donations');
    })->name('donations');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
