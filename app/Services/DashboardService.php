<?php

namespace App\Services;

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

    public function getUsersCount():int
    {
        return $this->userService->countUser();
    }
}