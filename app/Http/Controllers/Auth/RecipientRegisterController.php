<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RecipientProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RecipientRegisterController extends Controller
{
    /**
     * Display the recipient registration view.
     */
    public function create(): View
    {
        return view('auth.recipient-register');
    }

    /**
     * Handle an incoming recipient registration request.
     * Only creates user account - no help request at this stage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['required', 'string', 'max:20'],
            'location' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'consent' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => User::TYPE_USER,
        ]);

        // Create basic recipient profile for account approval
        RecipientProfile::create([
            'user_id' => $user->id,
            'phone' => $request->mobile,
            'location' => $request->location,
            'status' => 'pending', // Account pending approval
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('recipient.dashboard')
            ->with('info', 'Your account has been created and is pending approval. Once approved, you can submit help requests.');
    }
}
