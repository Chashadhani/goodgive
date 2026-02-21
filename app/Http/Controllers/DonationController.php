<?php

namespace App\Http\Controllers;

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

        $donation->load(['ngoPost', 'reviewer', 'items']);

        return view('donors.donations-show', compact('donation'));
    }
}
