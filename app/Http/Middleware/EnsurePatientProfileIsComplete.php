<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePatientProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // If no user logged in, continue normally
        if (!$user) {
            return $next($request);
        }

        // Only apply to users with "patient" role
        if ($user->role === 'patient') {

            // If patient profile does not exist → force to create one
            if (!$user->patient) {
                if (!$request->is('patient/profile/create')) {
                    return redirect()->route('patient.profile.create')
                        ->with('warning', 'Please complete your patient profile.');
                }
            }

            // If patient profile exists but incomplete
            if ($user->patient && !$user->patient->is_complete) {
                if (!$request->is('patient/profile/edit')) {
                    return redirect()->route('patient.profile.edit')
                        ->with('warning', 'Please complete your patient profile.');
                }
            }
        }

        return $next($request);
    }
}
