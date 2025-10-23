<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AppointmentResource;

class AppointmentService
{
    public function __construct(
        protected Appointment $appointmentModel
    ) {}

    public function getUserAppointments($status = 'all')
    {
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $statusOrder = ['approved', 'pending'];

        return AppointmentResource::collection(
            $this->appointmentModel
                ->with('service')
                ->where('user_id', $user->id)
                ->when($status !== 'all', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')")
                ->latest()
                ->get()
        );
    }

    public function countTodaysAppointments(): int
    {
        return $this->appointmentModel
            ->whereDate('date', now()->toDateString())
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
            ->whereDate('date', '>', now()->toDateString())
            ->count();
    }

    public function getAppointments($status = 'all')
    {
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $statusOrder = ['approved', 'pending', 'completed', 'cancelled'];

        return AppointmentResource::collection(
            $this->appointmentModel
                ->with('service')
                ->when($status !== 'all', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')")
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
}