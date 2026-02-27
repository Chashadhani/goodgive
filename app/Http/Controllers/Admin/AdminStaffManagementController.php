<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStaffManagementController extends Controller
{
    /**
     * List all staff members (approved users with type 'staff').
     */
    public function index(Request $request)
    {
        $query = User::where('user_type', User::TYPE_STAFF);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'paused') {
                $query->where('is_active', false);
            }
        }

        $staffMembers = $query->latest()->paginate(15);

        $stats = [
            'total' => User::where('user_type', User::TYPE_STAFF)->count(),
            'active' => User::where('user_type', User::TYPE_STAFF)->where('is_active', true)->count(),
            'paused' => User::where('user_type', User::TYPE_STAFF)->where('is_active', false)->count(),
        ];

        return view('admin.staff-management.index', compact('staffMembers', 'stats'));
    }

    /**
     * Pause a staff member (deactivate their account).
     */
    public function pause(User $user)
    {
        if ($user->user_type !== User::TYPE_STAFF) {
            return back()->with('error', 'This user is not a staff member.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot pause your own account.');
        }

        $user->update(['is_active' => false]);

        return back()->with('success', $user->name . ' has been paused. They can no longer log in.');
    }

    /**
     * Activate a paused staff member.
     */
    public function activate(User $user)
    {
        if ($user->user_type !== User::TYPE_STAFF) {
            return back()->with('error', 'This user is not a staff member.');
        }

        $user->update(['is_active' => true]);

        return back()->with('success', $user->name . ' has been reactivated.');
    }

    /**
     * Remove a staff member permanently.
     */
    public function remove(User $user)
    {
        if ($user->user_type !== User::TYPE_STAFF) {
            return back()->with('error', 'This user is not a staff member.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot remove your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.staff-management.index')
            ->with('success', $name . ' has been permanently removed.');
    }
}
