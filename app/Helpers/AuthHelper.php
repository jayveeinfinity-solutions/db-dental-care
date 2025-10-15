<?php

use Illuminate\Support\Facades\Auth;


if (! function_exists('redirectAfterLogin')) {
    function redirectAfterLogin()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        if ($user->hasRole(['superadmin', 'clinic_admin', 'dentist', 'receptionist'])) {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/');
    }
}