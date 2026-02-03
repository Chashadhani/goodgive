<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpRequestController;
use App\Http\Controllers\Auth\DonorRegisterController;
use App\Http\Controllers\Auth\NgoRegisterController;
use App\Http\Controllers\Auth\RecipientRegisterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\NgoVerificationController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\Admin\AdminHelpRequestController;
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

Route::get('/our-work', function () {
    return view('our-work');
})->name('our-work');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/join-staff', function () {
    return view('join-staff');
})->name('join-staff');

// Registration Routes (Guest Only) - Only for Donor, NGO, Recipient
Route::middleware('guest')->group(function () {
    // Donor Registration
    Route::get('/register/donor', [DonorRegisterController::class, 'create'])->name('donor.register');
    Route::post('/register/donor', [DonorRegisterController::class, 'store']);

    // NGO Registration
    Route::get('/register/ngo', [NgoRegisterController::class, 'create'])->name('ngo.register');
    Route::post('/register/ngo', [NgoRegisterController::class, 'store']);

    // Recipient Registration
    Route::get('/register/recipient', [RecipientRegisterController::class, 'create'])->name('recipient.register');
    Route::post('/register/recipient', [RecipientRegisterController::class, 'store']);
});

// Generic Dashboard redirect (for compatibility)
Route::get('/dashboard', function () {
    $user = auth()->user();
    // Admin/Staff go to admin panel
    if (in_array($user->user_type, ['admin', 'staff'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route($user->getDashboardRoute());
})->middleware(['auth'])->name('dashboard');

// =========================================
// ADMIN PANEL ROUTES (Admin & Staff only)
// =========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login (Guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Admin Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // Admin Panel Pages (Admin & Staff can access)
    Route::middleware(['auth', 'role:admin,staff'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        // NGO verification
        Route::get('/ngos', [NgoVerificationController::class, 'index'])->name('ngos.index');
        Route::get('/ngos/{user}', [NgoVerificationController::class, 'show'])->name('ngos.show');
        Route::patch('/ngos/{user}/verify', [NgoVerificationController::class, 'verify'])->name('ngos.verify');
        Route::patch('/ngos/{user}/reject', [NgoVerificationController::class, 'reject'])->name('ngos.reject');
        Route::patch('/ngos/{user}/pending', [NgoVerificationController::class, 'pending'])->name('ngos.pending');
        
        // User (Recipients) account verification
        Route::get('/users', [UserVerificationController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserVerificationController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/approve', [UserVerificationController::class, 'approve'])->name('users.approve');
        Route::patch('/users/{user}/reject', [UserVerificationController::class, 'reject'])->name('users.reject');
        Route::patch('/users/{user}/pending', [UserVerificationController::class, 'pending'])->name('users.pending');
        
        // Help Categories Management
        Route::get('/categories', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'destroy'])->name('categories.destroy');
        Route::patch('/categories/{category}/toggle', [\App\Http\Controllers\Admin\HelpCategoryController::class, 'toggleStatus'])->name('categories.toggle');
        
        // Help Requests Management
        Route::get('/requests', [AdminHelpRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/{helpRequest}', [AdminHelpRequestController::class, 'show'])->name('requests.show');
        Route::patch('/requests/{helpRequest}/approve', [AdminHelpRequestController::class, 'approve'])->name('requests.approve');
        Route::patch('/requests/{helpRequest}/reject', [AdminHelpRequestController::class, 'reject'])->name('requests.reject');
        Route::patch('/requests/{helpRequest}/in-progress', [AdminHelpRequestController::class, 'inProgress'])->name('requests.in-progress');
        Route::patch('/requests/{helpRequest}/complete', [AdminHelpRequestController::class, 'complete'])->name('requests.complete');
        Route::patch('/requests/{helpRequest}/pending', [AdminHelpRequestController::class, 'pending'])->name('requests.pending');
    });
});

// =========================================
// NGO ROUTES (role: ngo)
// =========================================
Route::middleware(['auth', 'role:ngo'])->prefix('ngo')->name('ngo.')->group(function () {
    Route::get('/dashboard', function () {
        return view('ngo.dashboard');
    })->name('dashboard');
    
    Route::get('/post-request', function () {
        return view('ngo.post-request');
    })->name('post-request');
    
    Route::get('/requests', function () {
        return view('ngo.requests');
    })->name('requests');
});

// =========================================
// DONOR ROUTES (role: donor)
// =========================================
Route::middleware(['auth', 'role:donor'])->prefix('donor')->name('donor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('donors.dashboard');
    })->name('dashboard');
    
    Route::get('/donations', function () {
        return view('donors.donations');
    })->name('donations');
    
    Route::get('/history', function () {
        return view('donors.history');
    })->name('history');
});

// =========================================
// RECIPIENT ROUTES (role: user - those who need help)
// =========================================
Route::middleware(['auth', 'role:user'])->prefix('recipient')->name('recipient.')->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    })->name('dashboard');
    
    Route::get('/eligibility-forum', function () {
        return view('users.eligibility-forum');
    })->name('eligibility-forum');
    
    // Help Requests - using resource controller
    Route::get('/requests', [HelpRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [HelpRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [HelpRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{helpRequest}', [HelpRequestController::class, 'show'])->name('requests.show');
    Route::get('/requests/{helpRequest}/edit', [HelpRequestController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{helpRequest}', [HelpRequestController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{helpRequest}', [HelpRequestController::class, 'destroy'])->name('requests.destroy');
});

// =========================================
// PROFILE ROUTES (All authenticated users)
// =========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
