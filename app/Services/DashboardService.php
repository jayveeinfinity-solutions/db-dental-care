<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;

class DashboardService
{
    public function __construct(
        protected AppointmentService $appointmentService,
        protected UserService $userService,
        protected PatientService $patientService
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
        return $this->patientService->countPatient();
    }

    public function getUsersCount(): int
    {
        return $this->userService->countUser();
    }

    /**
     * Get the chronological sequence of appointments specifically for today.
     */
    public function getTodaysAppointmentsSequence()
    {
        return Appointment::with(['patient', 'services', 'service', 'bookedBy'])
            ->whereDate('scheduled_at', Carbon::today())
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    /**
     * Compute clinic schedule density and walk-in patient capacity for capacity planning.
     */
    public function getClinicCapacityData(): array
    {
        $today = Carbon::today()->toDateString();
        $totalOperatingMinutes = 9 * 60; // 08:00 to 17:00 = 540 minutes
        $avgWalkInDurationMinutes = 45; // average procedure duration

        $appointmentsToday = Appointment::whereDate('scheduled_at', $today)
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->get();

        $bookedMinutes = $appointmentsToday->sum(fn($a) => $a->duration_minutes ?: 30);
        $availableMinutes = max(0, $totalOperatingMinutes - $bookedMinutes);
        $densityPercentage = min(100, round(($bookedMinutes / $totalOperatingMinutes) * 100));

        // Density level badge
        if ($densityPercentage >= 90) {
            $densityLevel = 'Full';
            $densityColor = 'red';
        } elseif ($densityPercentage >= 65) {
            $densityLevel = 'High';
            $densityColor = 'orange';
        } elseif ($densityPercentage >= 35) {
            $densityLevel = 'Moderate';
            $densityColor = 'blue';
        } else {
            $densityLevel = 'Low';
            $densityColor = 'emerald';
        }

        $estimatedWalkInCapacity = (int) floor($availableMinutes / $avgWalkInDurationMinutes);

        // Hourly timeline slots representation for today (08:00 to 17:00)
        $hourlySlots = [];
        $startHour = Carbon::parse("{$today} 08:00");
        for ($i = 0; $i < 9; $i++) {
            $slotTime = $startHour->copy()->addHours($i);
            $slotTimeEnd = $slotTime->copy()->addHour();
            $slotLabel = $slotTime->format('g:i A');

            // Find overlapping appointments in this hour
            $matchingAppointments = $appointmentsToday->filter(function($app) use ($slotTime, $slotTimeEnd) {
                $appStart = Carbon::parse($app->scheduled_at);
                $appDuration = $app->duration_minutes ?: 30;
                $appEnd = $appStart->copy()->addMinutes($appDuration);
                return $appStart->lt($slotTimeEnd) && $appEnd->gt($slotTime);
            });

            $hourlySlots[] = [
                'time'          => $slotLabel,
                'is_occupied'   => $matchingAppointments->isNotEmpty(),
                'appointments'  => $matchingAppointments->values(),
                'is_past'       => $slotTimeEnd->isPast(),
            ];
        }

        return [
            'total_operating_hours'     => 9.0,
            'booked_hours'              => round($bookedMinutes / 60, 1),
            'available_hours'           => round($availableMinutes / 60, 1),
            'booked_minutes'            => $bookedMinutes,
            'available_minutes'         => $availableMinutes,
            'density_percentage'        => $densityPercentage,
            'density_level'             => $densityLevel,
            'density_color'             => $densityColor,
            'estimated_walk_in_capacity'=> $estimatedWalkInCapacity,
            'hourly_slots'              => $hourlySlots,
        ];
    }
}