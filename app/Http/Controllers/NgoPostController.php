<?php

namespace App\Http\Controllers;

use App\Models\NgoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'request_type' => 'required|in:money,goods',
            'goal_amount' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'items' => 'required_if:request_type,goods|array|min:1',
            'items.*.item_name' => 'required_if:request_type,goods|string|max:255',
            'items.*.quantity' => 'required_if:request_type,goods|integer|min:1',
            'items.*.notes' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ngo-posts', 'public');
        }

        DB::transaction(function () use ($validated, $request) {
            $post = NgoPost::create(collect($validated)->except('items')->toArray());

            if ($validated['request_type'] === 'goods' && !empty($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    if (!empty($item['item_name'])) {
                        $post->items()->create([
                            'item_name' => $item['item_name'],
                            'quantity' => $item['quantity'],
                            'notes' => $item['notes'] ?? null,
                        ]);
                    }
                }
            }
        });

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

        $ngoPost->load('items');

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

        $ngoPost->load('items');

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
            'request_type' => 'required|in:money,goods',
            'goal_amount' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'items' => 'required_if:request_type,goods|array|min:1',
            'items.*.item_name' => 'required_if:request_type,goods|string|max:255',
            'items.*.quantity' => 'required_if:request_type,goods|integer|min:1',
            'items.*.notes' => 'nullable|string|max:500',
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

        DB::transaction(function () use ($validated, $ngoPost) {
            $ngoPost->update(collect($validated)->except('items')->toArray());

            // Delete old items and create new ones
            $ngoPost->items()->delete();

            if ($validated['request_type'] === 'goods' && !empty($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    if (!empty($item['item_name'])) {
                        $ngoPost->items()->create([
                            'item_name' => $item['item_name'],
                            'quantity' => $item['quantity'],
                            'notes' => $item['notes'] ?? null,
                        ]);
                    }
                }
            }
        });

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
        $query = NgoPost::approved()->with(['user', 'user.ngoProfile', 'items']);

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

        $ngoPost->load(['user', 'user.ngoProfile', 'items']);

        return view('ngo-post-show', compact('ngoPost'));
    }
}
