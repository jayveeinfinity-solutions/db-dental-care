<?php

namespace App\Services;

use App\Models\Appointment;
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

        $statusOrder = ['scheduled', 'pending', 'completed', 'cancelled'];

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
}