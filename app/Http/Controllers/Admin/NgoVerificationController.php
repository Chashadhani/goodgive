<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NgoProfile;
use App\Models\User;
use Illuminate\Http\Request;

class NgoVerificationController extends Controller
{
    /**
     * Display a listing of all NGOs
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = User::where('user_type', 'ngo')
            ->with('ngoProfile')
            ->latest();
        
        if ($status !== 'all') {
            $query->whereHas('ngoProfile', function ($q) use ($status) {
                $q->where('verification_status', $status);
            });
        }
        
        $ngos = $query->paginate(10);
        
        // Get counts for tabs
        $counts = [
            'all' => User::where('user_type', 'ngo')->count(),
            'pending' => NgoProfile::where('verification_status', 'pending')->count(),
            'verified' => NgoProfile::where('verification_status', 'verified')->count(),
            'rejected' => NgoProfile::where('verification_status', 'rejected')->count(),
        ];
        
        return view('admin.ngos.index', compact('ngos', 'status', 'counts'));
    }

    /**
     * Show NGO details
     */
    public function show(User $user)
    {
        $user->load('ngoProfile');
        
        return view('admin.ngos.show', compact('user'));
    }

    /**
     * Verify an NGO
     */
    public function verify(User $user)
    {
        if (!$user->ngoProfile) {
            return back()->with('error', 'NGO profile not found.');
        }

        $user->ngoProfile->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'NGO has been verified successfully.');
    }

    /**
     * Reject an NGO
     */
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if (!$user->ngoProfile) {
            return back()->with('error', 'NGO profile not found.');
        }

        $user->ngoProfile->update([
            'verification_status' => 'rejected',
            'verified_at' => null,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'NGO has been rejected.');
    }

    /**
     * Set NGO back to pending
     */
    public function pending(User $user)
    {
        if (!$user->ngoProfile) {
            return back()->with('error', 'NGO profile not found.');
        }

        $user->ngoProfile->update([
            'verification_status' => 'pending',
            'verified_at' => null,
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'NGO status set to pending.');
    }
}
