<?php

if (! function_exists('redirectAfterLogin')) {
    function redirectAfterLogin()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/');
        }

        if ($user->hasRole(['superadmin', 'clinic_admin', 'dentist', 'receptionist'])) {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/');
    }
}