<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecipientProfile;
use App\Models\User;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of all users who need help (recipients)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = User::where('user_type', 'user')
            ->with('recipientProfile')
            ->latest();
        
        if ($status !== 'all') {
            $query->whereHas('recipientProfile', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        
        $users = $query->paginate(10);
        
        // Get counts for tabs
        $counts = [
            'all' => User::where('user_type', 'user')->count(),
            'pending' => RecipientProfile::where('status', 'pending')->count(),
            'approved' => RecipientProfile::where('status', 'approved')->count(),
            'rejected' => RecipientProfile::where('status', 'rejected')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'status', 'counts'));
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        $user->load('recipientProfile');
        
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
