<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecipientProfile;
use App\Models\User;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of all users with role filtering
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $role = $request->get('role', 'all');
        
        $query = User::with(['donorProfile', 'ngoProfile', 'recipientProfile'])->latest();

        // Filter by role
        if ($role !== 'all') {
            $query->where('user_type', $role);
        }

        // Filter by status (only applies to recipients)
        if ($status !== 'all') {
            if ($role === 'all' || $role === 'user') {
                $query->where(function ($q) use ($status, $role) {
                    if ($role === 'user') {
                        $q->whereHas('recipientProfile', function ($sub) use ($status) {
                            $sub->where('status', $status);
                        });
                    } else {
                        // When filtering all roles by status, only filter recipients
                        $q->where('user_type', 'user')->whereHas('recipientProfile', function ($sub) use ($status) {
                            $sub->where('status', $status);
                        });
                    }
                });
            }
        }
        
        $users = $query->paginate(15);
        
        // Get counts
        $counts = [
            'all' => User::count(),
            'donor' => User::where('user_type', 'donor')->count(),
            'ngo' => User::where('user_type', 'ngo')->count(),
            'user' => User::where('user_type', 'user')->count(),
            'admin' => User::where('user_type', 'admin')->count(),
            'staff' => User::where('user_type', 'staff')->count(),
            'pending' => RecipientProfile::where('status', 'pending')->count(),
            'approved' => RecipientProfile::where('status', 'approved')->count(),
            'rejected' => RecipientProfile::where('status', 'rejected')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'status', 'role', 'counts'));
    }

    /**
     * Show user details for any role
     */
    public function show(User $user)
    {
        $user->load(['donorProfile', 'ngoProfile', 'recipientProfile']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Approve a user account
     */
    public function approve(User $user)
    {
        if (!$user->recipientProfile) {
            return back()->with('error', 'User profile not found.');
        }

        $user->recipientProfile->update([
            'status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'User account has been approved. They can now submit help requests.');
    }

    /**
     * Reject a user account
     */
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if (!$user->recipientProfile) {
            return back()->with('error', 'User profile not found.');
        }

        $user->recipientProfile->update([
            'status' => 'rejected',
            'approved_at' => null,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'User account has been rejected.');
    }

    /**
     * Set user back to pending
     */
    public function pending(User $user)
    {
        if (!$user->recipientProfile) {
            return back()->with('error', 'User profile not found.');
        }

        $user->recipientProfile->update([
            'status' => 'pending',
            'approved_at' => null,
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'User account status set to pending.');
    }
}
