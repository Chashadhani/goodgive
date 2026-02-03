<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DonorProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class DonorRegisterController extends Controller
{
    /**
     * Display the donor registration view.
     */
    public function create(): View
    {
        return view('auth.donor-register');
    }

    /**
     * Handle an incoming donor registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => User::TYPE_DONOR,
        ]);

        // Create donor profile
        DonorProfile::create([
            'user_id' => $user->id,
            'phone' => $request->mobile,
            'address' => $request->address,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('donor.dashboard')
            ->with('success', 'Welcome to GoodGive! Your donor account has been created successfully.');
    }
}
