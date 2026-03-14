<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = null;

        if ($user->user_type === 'donor') {
            $profile = $user->donorProfile;
        } elseif ($user->user_type === 'ngo') {
            $profile = $user->ngoProfile;
        } elseif ($user->user_type === 'user') {
            $profile = $user->recipientProfile;
        }

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->safe()->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update role-specific profile
        if ($user->user_type === 'donor' && $user->donorProfile) {
            $user->donorProfile->update($request->safe()->only(['phone', 'address']));
        } elseif ($user->user_type === 'ngo' && $user->ngoProfile) {
            $user->ngoProfile->update($request->safe()->only([
                'organization_name', 'address', 'contact_person', 'phone',
            ]));
        } elseif ($user->user_type === 'user' && $user->recipientProfile) {
            $user->recipientProfile->update($request->safe()->only([
                'phone', 'location', 'need_category', 'description',
            ]));
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
