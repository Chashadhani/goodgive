<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\NgoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

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

        $donation = DB::transaction(function () use ($validated) {
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

            return $donation;
        });

        // If online payment, initiate Stripe Checkout
        if ($donation->isMoney() && $donation->payment_method === Donation::PAYMENT_ONLINE) {
            return $this->initiateStripeCheckout($donation);
        }

        return redirect()->route('donor.donations.index')->with('success', 'Donation submitted successfully! It will be reviewed by an admin.');
    }

    /**
     * Create a Stripe Checkout Session and redirect to Stripe.
     */
    private function initiateStripeCheckout(Donation $donation)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => config('services.stripe.currency', 'usd'),
                        'product_data' => [
                            'name' => 'Donation #' . $donation->id . ' to ' . config('app.name', 'GoodGive'),
                            'description' => 'Thank you for your generous donation!',
                        ],
                        'unit_amount' => (int) round($donation->amount * 100), // Stripe expects cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('donor.stripe.success', $donation) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('donor.stripe.cancel', $donation),
                'client_reference_id' => (string) $donation->id,
                'customer_email' => Auth::user()->email,
                'metadata' => [
                    'donation_id' => $donation->id,
                    'donor_id' => Auth::id(),
                ],
            ]);

            // Store the session ID on the donation
            $donation->update(['stripe_session_id' => $session->id]);

            return redirect()->away($session->url);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout session creation failed', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('donor.donations.show', $donation)
                ->with('error', 'Unable to connect to Stripe. Your donation has been saved as pending. Please try again later.');
        }
    }

    /**
     * Handle successful Stripe payment callback.
     */
    public function stripeSuccess(Request $request, Donation $donation)
    {
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }

        // Prevent double-processing
        if ($donation->isConfirmed()) {
            return redirect()->route('donor.donations.show', $donation)
                ->with('info', 'This donation has already been processed.');
        }

        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('donor.donations.show', $donation)
                ->with('error', 'Invalid payment response. Please contact support.');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::retrieve($sessionId);

            // Verify the session belongs to this donation
            if ($session->client_reference_id !== (string) $donation->id) {
                Log::warning('Stripe session mismatch', [
                    'donation_id' => $donation->id,
                    'session_reference' => $session->client_reference_id,
                ]);
                return redirect()->route('donor.donations.show', $donation)
                    ->with('error', 'Payment verification failed. Please contact support.');
            }

            if ($session->payment_status === 'paid') {
                DB::transaction(function () use ($donation, $session) {
                    $donation->update([
                        'status' => Donation::STATUS_CONFIRMED,
                        'stripe_session_id' => $session->id,
                        'reviewed_at' => now(),
                        'admin_notes' => 'Auto-confirmed via Stripe payment. Payment Intent: ' . ($session->payment_intent ?? 'N/A'),
                    ]);

                    // Update donor profile stats (mirrors AdminDonationController::confirm())
                    $donorProfile = $donation->user->donorProfile;
                    if ($donorProfile) {
                        $donorProfile->increment('donation_count');
                        if ($donation->isMoney()) {
                            $donorProfile->increment('total_donated', $donation->amount);
                        }
                    }
                });

                return redirect()->route('donor.donations.show', $donation)
                    ->with('success', 'Payment successful! Your donation of $' . number_format($donation->amount, 2) . ' has been confirmed. Thank you for your generosity!');
            }

            return redirect()->route('donor.donations.show', $donation)
                ->with('error', 'Payment was not completed. Your donation remains pending. Please try again.');

        } catch (\Exception $e) {
            Log::error('Stripe payment verification failed', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('donor.donations.show', $donation)
                ->with('error', 'An error occurred while verifying your payment. Please contact support.');
        }
    }

    /**
     * Handle Stripe payment cancellation.
     */
    public function stripeCancel(Request $request, Donation $donation)
    {
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('donor.donations.show', $donation)
            ->with('info', 'Payment was cancelled. Your donation has been saved and you can try paying again later.');
    }

    /**
     * Retry Stripe payment for a pending online donation.
     */
    public function retryStripe(Donation $donation)
    {
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$donation->isPending() || !$donation->isMoney() || $donation->payment_method !== Donation::PAYMENT_ONLINE) {
            return back()->with('error', 'This donation cannot be retried for online payment.');
        }

        return $this->initiateStripeCheckout($donation);
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
