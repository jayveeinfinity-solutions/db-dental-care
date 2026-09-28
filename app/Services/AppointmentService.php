<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonInterval;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AppointmentResource;

class AppointmentService
{
    public function __construct(
        protected Appointment $appointmentModel
    ) {}

    public function getUserAppointments(User $user, $status = 'all')
    {
        $today = Carbon::today()->toDateString();

        return AppointmentResource::collection(
            $this->appointmentModel
                ->with(['service', 'services', 'transaction'])
                ->where('user_id', $user->id)
                ->when($status !== 'all', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderByRaw("
                    CASE
                        WHEN status = 'approved' AND DATE(scheduled_at) = '{$today}' THEN 1
                        WHEN status = 'pending' THEN 2
                        ELSE 3
                    END
                ")
                ->latest()
                ->get()
        );
    }

    public function countTodaysAppointments(): int
    {
        return $this->appointmentModel
            ->whereDate('scheduled_at', now()->toDateString())
            ->count();
    }

    public function countAppointmentByStatus($status = NULL): int
    {
        return $this->appointmentModel
            ->when($status !== NULL, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }

    public function countUpcomingAppointment() {
        return $this->appointmentModel
            ->where('scheduled_at', '>', Carbon::today())
            ->where('status', 'approved')
            ->count();
    }

    public function getAppointments($status = 'all')
    {
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        return AppointmentResource::collection(
            $this->appointmentModel
                ->with(['service', 'services', 'patient', 'bookedBy', 'transaction'])
                ->when($status !== 'all', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderByRaw("
                    CASE status
                        WHEN 'checked_in' THEN 1
                        WHEN 'approved' THEN 2
                        WHEN 'pending' THEN 3
                        WHEN 'completed' THEN 4
                        WHEN 'cancelled' THEN 5
                        ELSE 6
                    END
                ")
                ->latest()
                ->get()
        );
    }

    /**
     * Cancel an appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @param  string  $reason
     * @param  int  $cancelledBy
     * @return \App\Models\Appointment
     */
    public function cancel(Appointment $appointment, string $reason, int $cancelled_by_id): Appointment
    {
        DB::transaction(function () use ($appointment, $reason, $cancelled_by_id) {
            $appointment->update([
                'status' => 'cancelled',
                'cancellation_reason' => $reason,
                'cancelled_by_id' => $cancelled_by_id,
                'cancelled_at' => now(),
            ]);
        });

        return $appointment;
    }

    public function getTimes() {
        $start = Carbon::createFromTimeString('08:00');
        $end = Carbon::createFromTimeString('17:00');
        $interval = CarbonInterval::minutes(30);
        $times = [];

        for ($time = $start->copy(); $time->lte($end); $time->add($interval)) {
            $times[] = [
                'value' => $time->format('H:i'),
                'text' => $time->format('g:i A'),
            ];
        }

        return $times;
    }

    /**
     * Get ordered timetable for today divisible per 30 minutes.
     * Maps appointments to time slots and identifies open slots for walk-in customers.
     */
    public function getTodaysTimetable(): array
    {
        $today = Carbon::today();
        
        // Fetch all appointments for today
        $todaysAppointments = $this->appointmentModel
            ->with(['service', 'services', 'patient', 'bookedBy', 'transaction'])
            ->whereDate('scheduled_at', $today)
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $start = Carbon::createFromTimeString('08:00');
        $end = Carbon::createFromTimeString('17:00');
        $interval = CarbonInterval::minutes(30);

        $slots = [];
        $bookedCount = 0;
        $availableCount = 0;

        for ($time = $start->copy(); $time->lte($end); $time->add($interval)) {
            $timeString = $time->format('H:i');
            $endTime = $time->copy()->addMinutes(30);
            $slotLabel = $time->format('g:i A') . ' - ' . $endTime->format('g:i A');

            // Find non-cancelled appointment scheduled at this time slot
            $appointment = $todaysAppointments->first(function ($app) use ($timeString) {
                return Carbon::parse($app->scheduled_at)->format('H:i') === $timeString
                    && $app->status !== 'cancelled';
            });

            // If no active appointment, check if there was a cancelled one (slot is still available)
            $cancelledAppointment = null;
            if (!$appointment) {
                $cancelledAppointment = $todaysAppointments->first(function ($app) use ($timeString) {
                    return Carbon::parse($app->scheduled_at)->format('H:i') === $timeString
                        && $app->status === 'cancelled';
                });
            }

            $isBooked = !is_null($appointment);
            if ($isBooked) {
                $bookedCount++;
            } else {
                $availableCount++;
            }

            $slots[] = [
                'time'                  => $timeString,
                'time_formatted'        => $time->format('g:i A'),
                'end_time_formatted'    => $endTime->format('g:i A'),
                'label'                 => $slotLabel,
                'is_available'          => !$isBooked,
                'appointment'           => $appointment,
                'cancelled_appointment' => $cancelledAppointment,
            ];
        }

        return [
            'slots'              => $slots,
            'total_slots'        => count($slots),
            'booked_count'       => $bookedCount,
            'available_count'    => $availableCount,
            'appointments_today' => $todaysAppointments,
        ];
    }
}