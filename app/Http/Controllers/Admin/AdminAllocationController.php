<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\HelpRequest;
use App\Models\NgoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminAllocationController extends Controller
{
    /**
     * List all allocations with filters.
     */
    public function index(Request $request)
    {
        $query = Allocation::with(['donation.user', 'donationItem', 'allocatable', 'allocatedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhereHas('donation.user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        $allocations = $query->latest()->paginate(15);

        $stats = [
            'total' => Allocation::count(),
            'processing' => Allocation::where('status', 'processing')->count(),
            'delivery' => Allocation::where('status', 'delivery')->count(),
            'distributed' => Allocation::where('status', 'distributed')->count(),
        ];

        return view('admin.allocations.index', compact('allocations', 'stats'));
    }

    /**
     * Show allocation creation form.
     * Accepts ?target_type=ngo_post|help_request&target_id=X to pre-select target.
     */
    public function create(Request $request)
    {
        $targetType = $request->query('target_type'); // ngo_post or help_request
        $targetId = $request->query('target_id');
        $target = null;

        if ($targetType === 'ngo_post' && $targetId) {
            $target = NgoPost::with('items')->find($targetId);
        } elseif ($targetType === 'help_request' && $targetId) {
            $target = HelpRequest::with('items')->find($targetId);
        }

        // Determine what's needed
        $needsType = $target ? $target->request_type : null;

        // Get available stock
        if ($needsType === 'money') {
            // Confirmed money donations with remaining balance
            $availableDonations = Donation::with('user')
                ->where('status', 'confirmed')
                ->where('donation_type', 'money')
                ->get()
                ->filter(fn($d) => $d->remaining_amount > 0);
        } elseif ($needsType === 'goods') {
            // Confirmed goods donations with remaining items
            $availableDonations = Donation::with(['user', 'items.allocations'])
                ->where('status', 'confirmed')
                ->where('donation_type', 'goods')
                ->get()
                ->filter(fn($d) => $d->has_available_stock);
        } else {
            // Show all available stock
            $availableDonations = Donation::with(['user', 'items.allocations'])
                ->where('status', 'confirmed')
                ->get()
                ->filter(fn($d) => $d->has_available_stock);
        }

        // Also get available targets if none selected
        $ngoPostsNeedingHelp = NgoPost::where('status', 'approved')
            ->with('items')
            ->latest()
            ->get();

        $helpRequestsNeedingHelp = HelpRequest::whereIn('status', ['approved', 'in_progress'])
            ->with('items')
            ->latest()
            ->get();

        return view('admin.allocations.create', compact(
            'target', 'targetType', 'targetId', 'needsType',
            'availableDonations', 'ngoPostsNeedingHelp', 'helpRequestsNeedingHelp'
        ));
    }

    /**
     * Store a new allocation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'target_type' => 'required|in:ngo_post,help_request',
            'target_id' => 'required|integer',
            'allocation_type' => 'required|in:money,goods',
            'notes' => 'nullable|string|max:500',
            // For money
            'donation_id' => 'required_if:allocation_type,money|nullable|exists:donations,id',
            'amount' => 'required_if:allocation_type,money|nullable|numeric|min:0.01',
            // For goods (can allocate multiple items)
            'goods_allocations' => 'required_if:allocation_type,goods|nullable|array|min:1',
            'goods_allocations.*.donation_item_id' => 'required|exists:donation_items,id',
            'goods_allocations.*.quantity' => 'required|integer|min:1',
        ]);

        // Resolve target
        $allocatableType = $validated['target_type'] === 'ngo_post'
            ? NgoPost::class
            : HelpRequest::class;
        $allocatableId = $validated['target_id'];

        DB::transaction(function () use ($validated, $allocatableType, $allocatableId) {
            if ($validated['allocation_type'] === 'money') {
                $donation = Donation::findOrFail($validated['donation_id']);

                // Validate remaining amount
                if ($validated['amount'] > $donation->remaining_amount) {
                    abort(422, 'Amount exceeds available balance.');
                }

                Allocation::create([
                    'donation_id' => $donation->id,
                    'donation_item_id' => null,
                    'allocatable_type' => $allocatableType,
                    'allocatable_id' => $allocatableId,
                    'allocated_by' => Auth::id(),
                    'type' => 'money',
                    'amount' => $validated['amount'],
                    'quantity' => null,
                    'item_name' => null,
                    'status' => 'processing',
                    'notes' => $validated['notes'] ?? null,
                ]);
            } else {
                // Goods: create one allocation per item
                foreach ($validated['goods_allocations'] as $alloc) {
                    $item = DonationItem::findOrFail($alloc['donation_item_id']);

                    // Validate remaining quantity
                    if ($alloc['quantity'] > $item->remaining_quantity) {
                        abort(422, "Quantity exceeds available stock for '{$item->item_name}'.");
                    }

                    Allocation::create([
                        'donation_id' => $item->donation_id,
                        'donation_item_id' => $item->id,
                        'allocatable_type' => $allocatableType,
                        'allocatable_id' => $allocatableId,
                        'allocated_by' => Auth::id(),
                        'type' => 'goods',
                        'amount' => null,
                        'quantity' => $alloc['quantity'],
                        'item_name' => $item->item_name,
                        'status' => 'processing',
                        'notes' => $validated['notes'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.allocations.index')->with('success', 'Stock allocated successfully!');
    }

    /**
     * Show allocation detail.
     */
    public function show(Allocation $allocation)
    {
        $allocation->load(['donation.user.donorProfile', 'donationItem', 'allocatable', 'allocatedBy']);

        return view('admin.allocations.show', compact('allocation'));
    }

    /**
     * Advance allocation status: processing → delivery → distributed.
     */
    public function advanceStatus(Request $request, Allocation $allocation)
    {
        $nextStatus = $allocation->next_status;

        if (!$nextStatus) {
            return back()->with('error', 'This allocation cannot be advanced further.');
        }

        $allocation->update([
            'status' => $nextStatus,
            'notes' => $request->notes ?? $allocation->notes,
        ]);

        $label = match ($nextStatus) {
            'delivery' => 'moved to delivery',
            'distributed' => 'marked as distributed',
            default => 'updated',
        };

        return back()->with('success', "Allocation {$label} successfully!");
    }

    /**
     * Upload distribution proof photo.
     */
    public function uploadProof(Request $request, Allocation $allocation)
    {
        $request->validate([
            'proof_photo' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'proof_notes' => 'nullable|string|max:500',
        ]);

        $path = $request->file('proof_photo')->store('allocation-proofs', 'public');

        $allocation->update([
            'proof_photo' => $path,
            'proof_notes' => $request->proof_notes,
        ]);

        return back()->with('success', 'Distribution proof uploaded successfully!');
    }
}
