<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\NgoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDonationController extends Controller
{
    /**
     * Display all donations with filters.
     */
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'ngoPost', 'reviewer', 'items']);

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['money', 'goods'])) {
            $query->where('donation_type', $request->type);
        }

        $donations = $query->latest()->paginate(15);

        // Stats
        $totalDonations = Donation::count();
        $pendingDonations = Donation::pending()->count();
        $confirmedDonations = Donation::confirmed()->count();
        $rejectedDonations = Donation::where('status', 'rejected')->count();
        $totalMoneyDonated = Donation::confirmed()->money()->sum('amount');
        $totalGoodsDonations = Donation::confirmed()->goods()->count();

        return view('admin.donations.index', compact(
            'donations', 'totalDonations', 'pendingDonations', 'confirmedDonations',
            'rejectedDonations', 'totalMoneyDonated', 'totalGoodsDonations'
        ));
    }

    /**
     * Show a single donation detail.
     */
    public function show(Donation $donation)
    {
        $donation->load(['user.donorProfile', 'ngoPost', 'reviewer', 'items']);

        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Display donations made through NGO posts.
     */
    public function ngoDonations(Request $request)
    {
        $query = Donation::with(['user', 'ngoPost.user', 'reviewer', 'items'])
            ->whereNotNull('ngo_post_id');

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['money', 'goods'])) {
            $query->where('donation_type', $request->type);
        }

        // Filter by NGO post
        if ($request->has('ngo_post_id') && $request->ngo_post_id) {
            $query->where('ngo_post_id', $request->ngo_post_id);
        }

        $donations = $query->latest()->paginate(15);

        // Stats (NGO post donations only)
        $baseQuery = Donation::whereNotNull('ngo_post_id');
        $totalNgoDonations = (clone $baseQuery)->count();
        $pendingNgoDonations = (clone $baseQuery)->pending()->count();
        $confirmedNgoDonations = (clone $baseQuery)->confirmed()->count();
        $rejectedNgoDonations = (clone $baseQuery)->where('status', 'rejected')->count();
        $totalNgoMoneyDonated = (clone $baseQuery)->confirmed()->money()->sum('amount');
        $totalNgoGoodsDonations = (clone $baseQuery)->confirmed()->goods()->count();

        // Get NGO posts that have donations for the filter dropdown
        $ngoPostsWithDonations = NgoPost::whereHas('donations')
            ->with('user')
            ->orderBy('title')
            ->get();

        return view('admin.donations.ngo-donations', compact(
            'donations', 'totalNgoDonations', 'pendingNgoDonations', 'confirmedNgoDonations',
            'rejectedNgoDonations', 'totalNgoMoneyDonated', 'totalNgoGoodsDonations',
            'ngoPostsWithDonations'
        ));
    }

    /**
     * Confirm a donation.
     */
    public function confirm(Request $request, Donation $donation)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $donation->update([
            'status' => 'confirmed',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Update donor profile stats
        $donorProfile = $donation->user->donorProfile;
        if ($donorProfile) {
            $donorProfile->increment('donation_count');
            if ($donation->isMoney()) {
                $donorProfile->increment('total_donated', $donation->amount);
            }
        }

        return redirect()->route('admin.donations.show', $donation)->with('success', 'Donation confirmed successfully.');
    }

    /**
     * Reject a donation.
     */
    public function reject(Request $request, Donation $donation)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $donation->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.donations.show', $donation)->with('success', 'Donation rejected.');
    }

    /**
     * Set donation back to pending.
     */
    public function pending(Request $request, Donation $donation)
    {
        // If it was previously confirmed, revert donor stats
        if ($donation->isConfirmed()) {
            $donorProfile = $donation->user->donorProfile;
            if ($donorProfile) {
                $donorProfile->decrement('donation_count');
                if ($donation->isMoney()) {
                    $donorProfile->decrement('total_donated', $donation->amount);
                }
            }
        }

        $donation->update([
            'status' => 'pending',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return redirect()->route('admin.donations.show', $donation)->with('success', 'Donation set back to pending.');
    }
}
