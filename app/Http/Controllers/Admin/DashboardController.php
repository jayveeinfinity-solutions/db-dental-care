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
        $pendingAppointments = $this->dashboardService->getPendingAppointmentCount();
        $upcomingAppointments = $this->dashboardService->getUpcomingAppointmentCount();
        $patientCount = $this->dashboardService->getPatientCount();

        $todaysScheduleSequence = $this->dashboardService->getTodaysAppointmentsSequence();
        $capacityPlanning = $this->dashboardService->getClinicCapacityData();

        return view('admin.dashboard.index', compact(
            'todaysAppointments', 
            'pendingAppointments', 
            'upcomingAppointments', 
            'patientCount',
            'todaysScheduleSequence',
            'capacityPlanning'
        ));
    }
}
