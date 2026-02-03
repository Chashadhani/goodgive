<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNgoVerified
{
    /**
     * Handle an incoming request.
     * Ensures NGO is verified before accessing certain features.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isNgo()) {
            $ngoProfile = $user->ngoProfile;
            
            if (!$ngoProfile || !$ngoProfile->isVerified()) {
                return redirect()->route('ngo.dashboard')
                    ->with('warning', 'Your NGO account is pending verification. Some features are restricted.');
            }
        }

        return $next($request);
    }
}
