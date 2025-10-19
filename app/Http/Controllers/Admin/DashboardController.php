<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index() {
        $todaysAppointments = $this->dashboardService->getTodaysAppointmentCount();
        $pendingAppointments = 0;
        $upcomingAppointments = 0;
        $patientCount = 0;

        return view('admin.dashboard.index', compact('todaysAppointments', 'pendingAppointments', 'upcomingAppointments', 'patientCount'));
    }
}
