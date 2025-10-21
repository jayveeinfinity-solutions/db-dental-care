<?php

namespace App\Http\Controllers;

use App\Services\AppointmentService;

class UserProfileController extends Controller
{
    public function appointments() {
        return view('pages.user.appointments');
    }
}
