<?php

namespace App\Http\Controllers;

use App\Models\HelpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HelpRequestController extends Controller
{
    /**
     * Display list of user's help requests
     */
    public function index()
    {
        $requests = Auth::user()->helpRequests()->latest()->paginate(10);
        
        return view('users.requests.index', compact('requests'));
    }

    /**
     * Show form to create new help request
     */
    public function create()
    {
        // Check if user's account is approved
        $user = Auth::user();
        
        if (!$user->recipientProfile || $user->recipientProfile->status !== 'approved') {
            return redirect()->route('recipient.dashboard')
                ->with('error', 'Your account must be approved before you can submit help requests.');
        }
        
        return view('users.requests.create');
    }

    /**
     * Store a new help request
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Verify account is approved
        if (!$user->recipientProfile || $user->recipientProfile->status !== 'approved') {
            return redirect()->route('recipient.dashboard')
                ->with('error', 'Your account must be approved before you can submit help requests.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:education,healthcare,shelter,food,clothing,emergency,other',
            'description' => 'required|string|min:50|max:2000',
            'amount_needed' => 'nullable|numeric|min:0',
            'urgency' => 'required|in:low,medium,high,critical',
            'documents' => 'nullable|array|max:5',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        // Handle document uploads
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('help-request-documents/' . $user->id, 'public');
                $documentPaths[] = $path;
            }
        }

        $helpRequest = HelpRequest::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'location' => $user->recipientProfile->location,
            'amount_needed' => $validated['amount_needed'] ?? null,
            'urgency' => $validated['urgency'],
            'documents' => !empty($documentPaths) ? json_encode($documentPaths) : null,
            'status' => 'pending',
        ]);

        return redirect()->route('recipient.requests.index')
            ->with('success', 'Your help request has been submitted successfully. It will be reviewed shortly.');
    }

    /**
     * Show a specific help request
     */
    public function show(HelpRequest $helpRequest)
    {
        // Ensure user can only see their own requests
        if ($helpRequest->user_id !== Auth::id()) {
            abort(403);
        }

        return view('users.requests.show', compact('helpRequest'));
    }

    /**
     * Show form to edit a help request (only if pending)
     */
    public function edit(HelpRequest $helpRequest)
    {
        // Ensure user can only edit their own requests
        if ($helpRequest->user_id !== Auth::id()) {
            abort(403);
        }

        // Can only edit pending requests
        if (!$helpRequest->isPending()) {
            return redirect()->route('recipient.requests.show', $helpRequest)
                ->with('error', 'You can only edit pending requests.');
        }

        return view('users.requests.edit', compact('helpRequest'));
    }

    /**
     * Update a help request
     */
    public function update(Request $request, HelpRequest $helpRequest)
    {
        // Ensure user can only update their own requests
        if ($helpRequest->user_id !== Auth::id()) {
            abort(403);
        }

        // Can only update pending requests
        if (!$helpRequest->isPending()) {
            return redirect()->route('recipient.requests.show', $helpRequest)
                ->with('error', 'You can only edit pending requests.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:education,healthcare,shelter,food,clothing,emergency,other',
            'description' => 'required|string|min:50|max:2000',
            'amount_needed' => 'nullable|numeric|min:0',
            'urgency' => 'required|in:low,medium,high,critical',
            'documents' => 'nullable|array|max:5',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        // Handle new document uploads
        $documentPaths = $helpRequest->documents ? json_decode($helpRequest->documents, true) : [];
        
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('help-request-documents/' . Auth::id(), 'public');
                $documentPaths[] = $path;
            }
        }

        $helpRequest->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'amount_needed' => $validated['amount_needed'] ?? null,
            'urgency' => $validated['urgency'],
            'documents' => !empty($documentPaths) ? json_encode($documentPaths) : null,
        ]);

        return redirect()->route('recipient.requests.show', $helpRequest)
            ->with('success', 'Your help request has been updated.');
    }

    /**
     * Delete a help request (only if pending)
     */
    public function destroy(HelpRequest $helpRequest)
    {
        // Ensure user can only delete their own requests
        if ($helpRequest->user_id !== Auth::id()) {
            abort(403);
        }

        // Can only delete pending requests
        if (!$helpRequest->isPending()) {
            return redirect()->route('recipient.requests.show', $helpRequest)
                ->with('error', 'You can only delete pending requests.');
        }

        // Delete associated documents
        if ($helpRequest->documents) {
            $paths = json_decode($helpRequest->documents, true);
            foreach ($paths as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $helpRequest->delete();

        return redirect()->route('recipient.requests.index')
            ->with('success', 'Your help request has been deleted.');
    }
}
