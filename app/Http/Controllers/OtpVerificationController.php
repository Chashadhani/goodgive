<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OtpVerificationController extends Controller
{
    /**
     * Verify OTP and upload proof photo for an allocation.
     * Called by recipient (HelpRequest) or NGO (NgoPost) when they receive the delivery.
     */
    public function verify(Request $request, Allocation $allocation)
    {
        // Ensure the user is the target of this allocation
        $user = Auth::user();
        $allocatable = $allocation->allocatable;

        if (!$allocatable) {
            return back()->with('error', 'Allocation target not found.');
        }

        // Check ownership: recipient owns the help request, or NGO owns the post
        $isOwner = false;

        if ($allocation->allocatable_type === \App\Models\HelpRequest::class) {
            $isOwner = $allocatable->user_id === $user->id;
        } elseif ($allocation->allocatable_type === \App\Models\NgoPost::class) {
            $isOwner = $allocatable->user_id === $user->id;
        }

        if (!$isOwner) {
            abort(403, 'You are not authorized to verify this allocation.');
        }

        // Must be in delivery status
        if (!$allocation->isDelivery()) {
            return back()->with('error', 'OTP can only be verified when the allocation is in delivery status.');
        }

        // Must have an OTP generated
        if (!$allocation->hasOtp()) {
            return back()->with('error', 'No OTP has been generated for this allocation yet.');
        }

        // Already verified
        if ($allocation->isOtpVerified()) {
            return back()->with('error', 'OTP has already been verified for this allocation.');
        }

        // Validate input
        $request->validate([
            'otp_code' => 'required|string|size:6',
            'proof_photo' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'proof_notes' => 'nullable|string|max:500',
        ]);

        // Check OTP
        if ($request->otp_code !== $allocation->otp_code) {
            return back()->withErrors(['otp_code' => 'Invalid OTP code. Please check and try again.'])->withInput();
        }

        // OTP is correct — upload proof and mark as verified
        $path = $request->file('proof_photo')->store('allocation-proofs', 'public');

        $allocation->update([
            'otp_verified' => true,
            'otp_verified_at' => now(),
            'proof_photo' => $path,
            'proof_notes' => $request->proof_notes,
            'status' => Allocation::STATUS_DISTRIBUTED,
        ]);

        return back()->with('success', 'OTP verified successfully! The donation has been marked as distributed.');
    }
}
