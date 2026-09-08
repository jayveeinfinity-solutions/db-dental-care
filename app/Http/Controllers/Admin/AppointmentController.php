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
        $dateFilter = $request->query('date', 'all');

        $appointments = $this->appointmentService->getAppointments($status, $dateFilter);

        $appointments = collect($appointments)
            ->map(function ($appointmentResource) {
                return json_decode(json_encode($appointmentResource->resolve()));
            });

        return view('admin.appointments.index', compact('appointments', 'status', 'dateFilter'));
    }
}