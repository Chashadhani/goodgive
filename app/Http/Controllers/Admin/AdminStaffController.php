<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminStaffController extends Controller
{
    /**
     * List all staff applications with filters.
     */
    public function index(Request $request)
    {
        $query = StaffApplication::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nic', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest()->paginate(15);

        $stats = [
            'total' => StaffApplication::count(),
            'pending' => StaffApplication::where('status', 'pending')->count(),
            'approved' => StaffApplication::where('status', 'approved')->count(),
            'rejected' => StaffApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.staff.index', compact('applications', 'stats'));
    }

    /**
     * Show a single staff application.
     */
    public function show(StaffApplication $staffApplication)
    {
        $staffApplication->load(['reviewer', 'user']);

        return view('admin.staff.show', compact('staffApplication'));
    }

    /**
     * Approve application — generate random username & password, create user account.
     */
    public function approve(Request $request, StaffApplication $staffApplication)
    {
        if (!$staffApplication->isPending()) {
            return back()->with('error', 'This application has already been processed.');
        }

        // Check if email is already taken by a user
        if (User::where('email', $staffApplication->email)->exists()) {
            return back()->with('error', 'A user with this email already exists. Cannot create staff account.');
        }

        // Generate random username: staff_firstname_4digits
        $firstName = Str::lower(Str::before($staffApplication->full_name, ' '));
        $username = 'staff_' . $firstName . '_' . rand(1000, 9999);
        
        // Make sure username doesn't already exist as email
        while (User::where('email', $username . '@goodgive.staff')->exists()) {
            $username = 'staff_' . $firstName . '_' . rand(1000, 9999);
        }

        // Generate random password (8 chars: letters + numbers)
        $plainPassword = Str::upper(Str::random(3)) . rand(100, 999) . Str::lower(Str::random(2));

        // Create the staff user account
        $user = User::create([
            'name' => $staffApplication->full_name,
            'email' => $staffApplication->email,
            'password' => Hash::make($plainPassword),
            'user_type' => User::TYPE_STAFF,
        ]);

        // Update the application
        $staffApplication->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->admin_notes,
            'generated_username' => $username,
            'generated_password_plain' => $plainPassword,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.staff.show', $staffApplication)
            ->with('success', 'Application approved! Staff credentials have been generated.');
    }

    /**
     * Reject a staff application.
     */
    public function reject(Request $request, StaffApplication $staffApplication)
    {
        if (!$staffApplication->isPending()) {
            return back()->with('error', 'This application has already been processed.');
        }

        $staffApplication->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Application has been rejected.');
    }
}
