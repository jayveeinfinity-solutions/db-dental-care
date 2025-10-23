<?php

namespace App\Services;

use App\Models\User;

class DashboardService
{
    public function __construct(
        protected AppointmentService $appointmentService,
        protected UserService $userService
    ) {}

    public function getTodaysAppointmentCount(): int
    {
        return $this->appointmentService->countTodaysAppointments();
    }

    public function getPendingAppointmentCount(): int
    {
        return $this->appointmentService->countAppointmentByStatus('pending');
    }

    public function getUpcomingAppointmentCount(): int
    {
        return $this->appointmentService->countUpcomingAppointment();
    }

    public function getPatientCount() {
        return $this->userService->countPatient();
    }

    public function getUsersCount():int
    {
        return $this->userService->countUser();
    }
}