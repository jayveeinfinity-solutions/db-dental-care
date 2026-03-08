<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
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
        return AppointmentResource::collection(
            $this->appointmentModel
                ->with('service')
                ->where('user_id', $user->id)
                ->when($status !== 'all', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderByRaw("
                    CASE
                        WHEN status = 'approved' AND DATE(scheduled_at) = CURDATE() THEN 1
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