<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\NgoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Show the donation form (direct donation or linked to an NGO post).
     */
    public function create(Request $request)
    {
        $ngoPost = null;
        if ($request->has('ngo_post_id')) {
            $ngoPost = NgoPost::where('id', $request->ngo_post_id)
                ->where('status', 'approved')
                ->first();
        }

        return view('donors.donations-create', compact('ngoPost'));
    }

    /**
     * Store a new donation.
     */
    public function store(Request $request)
    {
        $rules = [
            'donation_type' => 'required|in:money,goods',
            'ngo_post_id' => 'nullable|exists:ngo_posts,id',
            'donor_notes' => 'nullable|string|max:500',
        ];

        if ($request->donation_type === 'money') {
            $rules['amount'] = 'required|numeric|min:1';
            $rules['payment_method'] = 'required|in:pickup,online';
        } else {
            $rules['items'] = 'required|array|min:1';
            $rules['items.*.item_name'] = 'required|string|max:255';
            $rules['items.*.quantity'] = 'required|integer|min:1';
            $rules['items.*.notes'] = 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $request) {
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'ngo_post_id' => $validated['ngo_post_id'] ?? null,
                'donation_type' => $validated['donation_type'],
                'amount' => $validated['donation_type'] === 'money' ? $validated['amount'] : null,
                'payment_method' => $validated['donation_type'] === 'money' ? $validated['payment_method'] : null,
                'donor_notes' => $validated['donor_notes'] ?? null,
                'status' => 'pending',
            ]);

            // Create donation items for goods
            if ($validated['donation_type'] === 'goods' && isset($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    $donation->items()->create([
                        'item_name' => $item['item_name'],
                        'quantity' => $item['quantity'],
                        'notes' => $item['notes'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('donor.donations.index')->with('success', 'Donation submitted successfully! It will be reviewed by an admin.');
    }

    /**
     * List all donations by the current donor.
     */
    public function index(Request $request)
    {
        $query = Donation::where('user_id', Auth::id())->with(['ngoPost', 'items']);

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['money', 'goods'])) {
            $query->where('donation_type', $request->type);
        }

        $donations = $query->latest()->paginate(10);

        // Stats
        $totalDonations = Donation::where('user_id', Auth::id())->count();
        $confirmedDonations = Donation::where('user_id', Auth::id())->confirmed()->count();
        $pendingDonations = Donation::where('user_id', Auth::id())->pending()->count();
        $totalMoneyDonated = Donation::where('user_id', Auth::id())->confirmed()->money()->sum('amount');

        return view('donors.donations-index', compact(
            'donations', 'totalDonations', 'confirmedDonations', 'pendingDonations', 'totalMoneyDonated'
        ));
    }

    /**
     * Show a single donation detail.
     */
    public function show(Donation $donation)
    {
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }

        $donation->load(['ngoPost', 'reviewer', 'items.allocations.allocatable', 'allocations.allocatable']);

        return view('donors.donations-show', compact('donation'));
    }

    /**
     * Show allocation tracking for a donation (donor sees where their items went).
     */
    public function tracking(Donation $donation)
    {
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }

        $donation->load([
            'items.allocations.allocatable',
            'allocations.allocatable',
            'allocations.allocatedBy',
        ]);

        return view('donors.donations-tracking', compact('donation'));
    }

    /**
     * Generate OTP for an allocation (donor action).
     * The OTP is shared with the recipient/NGO so they can verify distribution.
     */
    public function generateOtp(Allocation $allocation)
    {
        // Ensure the donor owns this donation
        if ($allocation->donation->user_id !== Auth::id()) {
            abort(403);
        }

        // OTP can only be generated when allocation is in processing status
        if (!$allocation->isProcessing()) {
            return back()->with('error', 'OTP can only be generated when allocation is in processing status.');
        }

        // Don't regenerate if already exists
        if ($allocation->hasOtp()) {
            return back()->with('error', 'OTP has already been generated for this allocation.');
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $allocation->update([
            'otp_code' => $otp,
            'otp_generated_at' => now(),
        ]);

        return back()->with('success', 'OTP generated successfully! The recipient/NGO can now see the OTP code.');
    }
}
