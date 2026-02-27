<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpRequestController;
use App\Http\Controllers\NgoPostController;
use App\Http\Controllers\Auth\DonorRegisterController;
use App\Http\Controllers\Auth\NgoRegisterController;
use App\Http\Controllers\Auth\RecipientRegisterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\NgoVerificationController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\Admin\AdminHelpRequestController;
use App\Http\Controllers\Admin\AdminNgoPostController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Admin\AdminAllocationController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminStaffManagementController;
use App\Http\Controllers\StaffApplicationController;
use App\Http\Controllers\OtpVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/ngos-posts', [NgoPostController::class, 'publicIndex'])->name('ngos-posts');

Route::get('/ngos-posts/{ngoPost}', [NgoPostController::class, 'publicShow'])->name('ngo-post.show');

Route::get('/our-work', function () {
    return view('our-work');
})->name('our-work');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/join-staff', function () {
    return view('join-staff');
})->name('join-staff');

Route::post('/join-staff', [StaffApplicationController::class, 'store'])->name('staff.apply');

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

        // NGO Posts Management
        Route::get('/ngo-posts', [AdminNgoPostController::class, 'index'])->name('ngo-posts.index');
        Route::get('/ngo-posts/{ngoPost}', [AdminNgoPostController::class, 'show'])->name('ngo-posts.show');
        Route::patch('/ngo-posts/{ngoPost}/approve', [AdminNgoPostController::class, 'approve'])->name('ngo-posts.approve');
        Route::patch('/ngo-posts/{ngoPost}/reject', [AdminNgoPostController::class, 'reject'])->name('ngo-posts.reject');
        Route::patch('/ngo-posts/{ngoPost}/pending', [AdminNgoPostController::class, 'pending'])->name('ngo-posts.pending');

        // Donations Management
        Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::get('/donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');
        Route::patch('/donations/{donation}/confirm', [AdminDonationController::class, 'confirm'])->name('donations.confirm');
        Route::patch('/donations/{donation}/reject', [AdminDonationController::class, 'reject'])->name('donations.reject');
        Route::patch('/donations/{donation}/pending', [AdminDonationController::class, 'pending'])->name('donations.pending');

        // Allocations Management (allocate stock to NGO posts / help requests)
        Route::get('/allocations', [AdminAllocationController::class, 'index'])->name('allocations.index');
        Route::get('/allocations/create', [AdminAllocationController::class, 'create'])->name('allocations.create');
        Route::post('/allocations', [AdminAllocationController::class, 'store'])->name('allocations.store');
        Route::get('/allocations/{allocation}', [AdminAllocationController::class, 'show'])->name('allocations.show');
        Route::patch('/allocations/{allocation}/advance', [AdminAllocationController::class, 'advanceStatus'])->name('allocations.advance');
        Route::post('/allocations/{allocation}/proof', [AdminAllocationController::class, 'uploadProof'])->name('allocations.proof');
        Route::post('/allocations/{allocation}/verify-otp', [AdminAllocationController::class, 'verifyOtpAndDistribute'])->name('allocations.verify-otp');

        // Staff Applications Management
        Route::get('/staff', [AdminStaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/{staffApplication}', [AdminStaffController::class, 'show'])->name('staff.show');
        Route::patch('/staff/{staffApplication}/approve', [AdminStaffController::class, 'approve'])->name('staff.approve');
        Route::patch('/staff/{staffApplication}/reject', [AdminStaffController::class, 'reject'])->name('staff.reject');

        // Staff Management (pause, activate, remove)
        Route::get('/staff-management', [AdminStaffManagementController::class, 'index'])->name('staff-management.index');
        Route::patch('/staff-management/{user}/pause', [AdminStaffManagementController::class, 'pause'])->name('staff-management.pause');
        Route::patch('/staff-management/{user}/activate', [AdminStaffManagementController::class, 'activate'])->name('staff-management.activate');
        Route::delete('/staff-management/{user}/remove', [AdminStaffManagementController::class, 'remove'])->name('staff-management.remove');
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

    // NGO Posts CRUD
    Route::get('/posts', [NgoPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [NgoPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [NgoPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{ngoPost}', [NgoPostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{ngoPost}/edit', [NgoPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{ngoPost}', [NgoPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{ngoPost}', [NgoPostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{ngoPost}/tracking', [NgoPostController::class, 'tracking'])->name('posts.tracking');
});

// =========================================
// DONOR ROUTES (role: donor)
// =========================================
Route::middleware(['auth', 'role:donor'])->prefix('donor')->name('donor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('donors.dashboard');
    })->name('dashboard');
    
    // Donations CRUD
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
    Route::get('/donations/{donation}/tracking', [DonationController::class, 'tracking'])->name('donations.tracking');
    Route::post('/allocations/{allocation}/generate-otp', [DonationController::class, 'generateOtp'])->name('allocation.generate-otp');
    
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
    Route::get('/requests/{helpRequest}/tracking', [HelpRequestController::class, 'tracking'])->name('requests.tracking');
});

// =========================================
// PROFILE ROUTES (All authenticated users)
// =========================================
Route::middleware('auth')->group(function () {
    // OTP Verification (recipient or NGO verifies delivery)
    Route::post('/otp-verify/{allocation}', [OtpVerificationController::class, 'verify'])->name('otp.verify');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
