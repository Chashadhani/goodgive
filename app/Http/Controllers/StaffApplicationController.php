<?php

namespace App\Http\Controllers;

use App\Models\StaffApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffApplicationController extends Controller
{
    /**
     * Handle staff application form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:staff_applications,email',
            'phone' => 'required|string|max:20',
            'nic' => 'required|string|max:50',
            'address' => 'required|string|max:1000',
            'position' => 'required|in:field_officer,coordinator,volunteer_manager,logistics,data_entry,community_outreach,other',
            'experience' => 'required|string|max:2000',
            'motivation' => 'required|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'terms' => 'required|accepted',
        ]);

        // Handle resume upload
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('staff-resumes', 'public');
        }

        StaffApplication::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'nic' => $validated['nic'],
            'address' => $validated['address'],
            'position' => $validated['position'],
            'experience' => $validated['experience'],
            'motivation' => $validated['motivation'],
            'resume' => $resumePath,
            'status' => 'pending',
        ]);

        return redirect()->route('join-staff')
            ->with('success', 'Your application has been submitted successfully! We will review it within 3-5 business days. If approved, your login credentials will be generated.');
    }
}
