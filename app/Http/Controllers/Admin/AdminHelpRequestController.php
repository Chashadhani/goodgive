<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpRequest;
use App\Models\HelpCategory;
use Illuminate\Http\Request;

class AdminHelpRequestController extends Controller
{
    /**
     * Display all help requests
     */
    public function index(Request $request)
    {
        $query = HelpRequest::with(['user', 'user.recipientProfile', 'items']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by urgency
        if ($request->filled('urgency')) {
            $query->where('urgency', $request->urgency);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Prioritize by urgency if sorting by urgency
        if ($sortField === 'urgency') {
            $query->orderByRaw("FIELD(urgency, 'critical', 'high', 'medium', 'low') " . ($sortDirection === 'desc' ? 'ASC' : 'DESC'));
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $requests = $query->paginate(15)->withQueryString();
        $categories = HelpCategory::active()->ordered()->get();

        // Get counts for stats
        $stats = [
            'total' => HelpRequest::count(),
            'pending' => HelpRequest::where('status', 'pending')->count(),
            'approved' => HelpRequest::where('status', 'approved')->count(),
            'rejected' => HelpRequest::where('status', 'rejected')->count(),
            'in_progress' => HelpRequest::where('status', 'in_progress')->count(),
            'completed' => HelpRequest::where('status', 'completed')->count(),
        ];

        return view('admin.requests.index', compact('requests', 'categories', 'stats'));
    }

    /**
     * Show a specific help request
     */
    public function show(HelpRequest $helpRequest)
    {
        $helpRequest->load(['user', 'user.recipientProfile', 'items']);
        
        return view('admin.requests.show', compact('helpRequest'));
    }

    /**
     * Approve a help request
     */
    public function approve(Request $request, HelpRequest $helpRequest)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $helpRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Help request has been approved successfully.');
    }

    /**
     * Reject a help request
     */
    public function reject(Request $request, HelpRequest $helpRequest)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ], [
            'admin_notes.required' => 'Please provide a reason for rejection.',
        ]);

        $helpRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Help request has been rejected.');
    }

    /**
     * Mark request as in progress
     */
    public function inProgress(Request $request, HelpRequest $helpRequest)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $helpRequest->update([
            'status' => 'in_progress',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Help request marked as in progress.');
    }

    /**
     * Mark request as completed
     */
    public function complete(Request $request, HelpRequest $helpRequest)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $helpRequest->update([
            'status' => 'completed',
            'admin_notes' => $request->admin_notes,
            'completed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Help request marked as completed.');
    }

    /**
     * Reset to pending
     */
    public function pending(Request $request, HelpRequest $helpRequest)
    {
        $helpRequest->update([
            'status' => 'pending',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => null,
            'reviewed_by' => null,
        ]);

        return redirect()->back()->with('success', 'Help request status reset to pending.');
    }
}
