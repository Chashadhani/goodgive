<?php

namespace App\Http\Controllers;

use App\Models\NgoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NgoPostController extends Controller
{
    /**
     * Display NGO's own posts.
     */
    public function index()
    {
        $posts = NgoPost::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('ngo.posts.index', compact('posts'));
    }

    /**
     * Show create post form.
     */
    public function create()
    {
        return view('ngo.posts.create');
    }

    /**
     * Store a new post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'category' => 'required|string|max:100',
            'urgency' => 'required|in:normal,urgent,critical',
            'goal_amount' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ngo-posts', 'public');
        }

        NgoPost::create($validated);

        return redirect()->route('ngo.posts.index')->with('success', 'Post created successfully! It will be visible after admin approval.');
    }

    /**
     * Show a specific post (NGO's own).
     */
    public function show(NgoPost $ngoPost)
    {
        // Ensure the NGO can only see their own posts
        if ($ngoPost->user_id !== Auth::id()) {
            abort(403);
        }

        return view('ngo.posts.show', compact('ngoPost'));
    }

    /**
     * Show edit form.
     */
    public function edit(NgoPost $ngoPost)
    {
        if ($ngoPost->user_id !== Auth::id()) {
            abort(403);
        }

        return view('ngo.posts.edit', compact('ngoPost'));
    }

    /**
     * Update the post.
     */
    public function update(Request $request, NgoPost $ngoPost)
    {
        if ($ngoPost->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'category' => 'required|string|max:100',
            'urgency' => 'required|in:normal,urgent,critical',
            'goal_amount' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ngoPost->image) {
                Storage::disk('public')->delete($ngoPost->image);
            }
            $validated['image'] = $request->file('image')->store('ngo-posts', 'public');
        }

        // Reset to pending on edit so admin re-reviews
        $validated['status'] = 'pending';
        $validated['reviewed_by'] = null;
        $validated['reviewed_at'] = null;
        $validated['admin_notes'] = null;

        $ngoPost->update($validated);

        return redirect()->route('ngo.posts.index')->with('success', 'Post updated. It will be re-reviewed by admin.');
    }

    /**
     * Delete a post.
     */
    public function destroy(NgoPost $ngoPost)
    {
        if ($ngoPost->user_id !== Auth::id()) {
            abort(403);
        }

        if ($ngoPost->image) {
            Storage::disk('public')->delete($ngoPost->image);
        }

        $ngoPost->delete();

        return redirect()->route('ngo.posts.index')->with('success', 'Post deleted successfully.');
    }

    // ============================================
    // PUBLIC ROUTES (no auth required)
    // ============================================

    /**
     * Public listing of approved NGO posts.
     */
    public function publicIndex(Request $request)
    {
        $query = NgoPost::approved()->with(['user', 'user.ngoProfile']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        if ($sort === 'urgent') {
            $query->orderByRaw("FIELD(urgency, 'critical', 'urgent', 'normal')");
        } else {
            $query->latest();
        }

        $posts = $query->paginate(12);

        return view('ngos-posts', compact('posts'));
    }

    /**
     * Public view of a single approved post.
     */
    public function publicShow(NgoPost $ngoPost)
    {
        if (!$ngoPost->isApproved()) {
            abort(404);
        }

        $ngoPost->load(['user', 'user.ngoProfile']);

        return view('ngo-post-show', compact('ngoPost'));
    }
}
