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
        $todaysAppointment = $this->dashboardService->getTodaysAppointmentCount();
        $usersCount = $this->dashboardService->getUsersCount();

        return view('admin.dashboard.index', compact('todaysAppointment', 'usersCount'));
    }
}
