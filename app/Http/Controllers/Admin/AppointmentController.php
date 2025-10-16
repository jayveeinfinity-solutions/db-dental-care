<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {}

    public function index(Request $request) {
        $status = $request->query('status', 'all');
        $appointments = $this->appointmentService->getAppointments($status);

        return view('admin.appointments.index', compact('appointments'));
    }
}