<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HelpCategoryController extends Controller
{
    /**
     * Display a listing of help categories.
     */
    public function index()
    {
        $categories = HelpCategory::ordered()->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:help_categories,name',
            'icon' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        HelpCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Help category created successfully.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(HelpCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, HelpCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:help_categories,name,' . $category->id,
            'icon' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Help category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(HelpCategory $category)
    {
        // Check if category is in use
        $requestCount = $category->helpRequests()->count();
        
        if ($requestCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', "Cannot delete category. It is being used by {$requestCount} help request(s).");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Help category deleted successfully.');
    }

    /**
     * Toggle category active status.
     */
    public function toggleStatus(HelpCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' has been {$status}.");
    }
}
