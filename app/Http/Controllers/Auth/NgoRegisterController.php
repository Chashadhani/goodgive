<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NgoProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NgoRegisterController extends Controller
{
    /**
     * Display the NGO registration view.
     */
    public function create(): View
    {
        return view('auth.ngo-register');
    }

    /**
     * Handle an incoming NGO registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'org_name' => ['required', 'string', 'max:255'],
            'reg_number' => ['required', 'string', 'max:100', 'unique:ngo_profiles,registration_number'],
            'address' => ['required', 'string', 'max:500'],
            'contact_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'documents' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240'],
            'password' => ['required', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Handle document upload
        $documentPath = null;
        if ($request->hasFile('documents')) {
            $documentPath = $request->file('documents')->store('ngo-documents', 'public');
        }

        $user = User::create([
            'name' => $request->org_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => User::TYPE_NGO,
        ]);

        // Create NGO profile
        NgoProfile::create([
            'user_id' => $user->id,
            'organization_name' => $request->org_name,
            'registration_number' => $request->reg_number,
            'address' => $request->address,
            'contact_person' => $request->contact_name,
            'phone' => $request->phone,
            'documents' => $documentPath,
            'verification_status' => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('ngo.dashboard')
            ->with('info', 'Your NGO registration has been submitted. Please wait for admin verification.');
    }
}
