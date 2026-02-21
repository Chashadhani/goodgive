<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NgoPost;
use Illuminate\Http\Request;

class AdminNgoPostController extends Controller
{
    /**
     * Display all NGO posts for admin review.
     */
    public function index(Request $request)
    {
        $query = NgoPost::with(['user', 'user.ngoProfile', 'items']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user.ngoProfile', function ($q) use ($search) {
                      $q->where('organization_name', 'like', "%{$search}%");
                  });
            });
        }

        $query->latest();
        $posts = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => NgoPost::count(),
            'pending' => NgoPost::where('status', 'pending')->count(),
            'approved' => NgoPost::where('status', 'approved')->count(),
            'rejected' => NgoPost::where('status', 'rejected')->count(),
        ];

        return view('admin.ngo-posts.index', compact('posts', 'stats'));
    }

    /**
     * Show a specific NGO post.
     */
    public function show(NgoPost $ngoPost)
    {
        $ngoPost->load(['user', 'user.ngoProfile', 'reviewer', 'items', 'allocations.donation.user']);

        return view('admin.ngo-posts.show', compact('ngoPost'));
    }

    /**
     * Approve a post.
     */
    public function approve(Request $request, NgoPost $ngoPost)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $ngoPost->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'NGO post has been approved and is now visible publicly.');
    }

    /**
     * Reject a post.
     */
    public function reject(Request $request, NgoPost $ngoPost)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $ngoPost->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'NGO post has been rejected.');
    }

    /**
     * Reset to pending.
     */
    public function pending(NgoPost $ngoPost)
    {
        $ngoPost->update([
            'status' => 'pending',
            'admin_notes' => null,
            'reviewed_at' => null,
            'reviewed_by' => null,
        ]);

        return redirect()->back()->with('success', 'NGO post has been set back to pending.');
    }
}
