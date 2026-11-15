<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use Carbon\CarbonInterval;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AppointmentResource;
use App\Events\AppointmentStatusChanged;

class AppointmentService
{
    public function __construct(
        protected Appointment $appointmentModel
    ) {}

    public function getUserAppointments(User $user, $status = 'all')
    {
        return AppointmentResource::collection(
            $this->appointmentModel
                ->with(['service', 'services'])
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
            ->where('status', '!=', 'cancelled')
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

    public function getAppointments($status = 'all', $dateFilter = 'all')
    {
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $statusOrder = ['approved', 'pending', 'completed', 'cancelled'];

        return AppointmentResource::collection(
            $this->appointmentModel
                ->with(['service', 'services', 'patient', 'bookedBy'])
                ->when($status !== 'all', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($dateFilter === 'today', function($query) {
                    $query->whereDate('scheduled_at', Carbon::today());
                })
                ->when($dateFilter === 'this_week', function($query) {
                    $query->whereBetween('scheduled_at', [
                        Carbon::now()->startOfWeek()->startOfDay(),
                        Carbon::now()->endOfWeek()->endOfDay()
                    ]);
                })
                ->when($dateFilter === 'this_month', function($query) {
                    $query->whereBetween('scheduled_at', [
                        Carbon::now()->startOfMonth()->startOfDay(),
                        Carbon::now()->endOfMonth()->endOfDay()
                    ]);
                })
                ->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')")
                ->orderBy('scheduled_at', 'asc')
                ->get()
        );
    }

    /**
     * Cancel an appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @param  string  $reason
     * @param  int  $cancelled_by_id
     * @return \App\Models\Appointment
     */
    public function cancel(Appointment $appointment, string $reason, int $cancelled_by_id): Appointment
    {
        $oldStatus = $appointment->status;

        DB::transaction(function () use ($appointment, $reason, $cancelled_by_id) {
            $appointment->update([
                'status' => 'cancelled',
                'cancellation_reason' => $reason,
                'cancelled_by_id' => $cancelled_by_id,
                'cancelled_at' => now(),
            ]);
        });

        // Fire status changed event
        event(new AppointmentStatusChanged($appointment, $oldStatus, 'cancelled'));

        return $appointment;
    }

    /**
     * Standard clinic operating slot times (30-minute intervals from 08:00 to 16:30)
     */
    public function getTimes(): array
    {
        $start = Carbon::createFromTimeString('08:00');
        $end = Carbon::createFromTimeString('16:30');
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
     * Calculate total duration in minutes based on an array of service IDs.
     */
    public function calculateDuration(array $serviceIds): int
    {
        if (empty($serviceIds)) {
            return 30;
        }

        $services = Service::whereIn('id', $serviceIds)->get();
        $totalDuration = 0;

        foreach ($services as $service) {
            $duration = $service->duration_minutes;
            if (!$duration) {
                // Fallbacks according to rev-1.md:
                // Consultation: 10 minutes
                if (stripos($service->name, 'consultation') !== false) {
                    $duration = 10;
                } elseif (stripos($service->name, 'extraction') !== false) {
                    // Extractions: variable duration
                    $duration = (stripos($service->name, 'complicated') !== false || stripos($service->name, 'impaction') !== false) ? 60 : 30;
                } else {
                    // General services: 30 minutes to 1 hour
                    $duration = 30;
                }
            }
            $totalDuration += $duration;
        }

        // Return calculated duration (minimum 15 minutes)
        return max(15, $totalDuration);
    }

    /**
     * Get available slots for a given date and duration.
     * Evaluates consecutive free slots, past times, and booked appointments.
     */
    public function getAvailableSlots(string $date, int $durationMinutes = 30): array
    {
        $times = $this->getTimes();
        $dateCarbon = Carbon::parse($date);
        $isToday = $dateCarbon->isToday();
        $now = Carbon::now();
        $clinicClose = Carbon::parse("{$date} 17:00");

        // Fetch existing appointments on this date with active status (pending, approved, completed)
        $existingAppointments = $this->appointmentModel
            ->whereDate('scheduled_at', $date)
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->get();

        $occupiedIntervals = [];
        foreach ($existingAppointments as $app) {
            $start = Carbon::parse($app->scheduled_at);
            $duration = $app->duration_minutes ?: 30;
            $end = $start->copy()->addMinutes($duration);
            $occupiedIntervals[] = [
                'start' => $start,
                'end' => $end,
                'status' => $app->status,
            ];
        }

        $slots = [];
        foreach ($times as $t) {
            $slotStart = Carbon::parse("{$date} {$t['value']}");
            $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);

            $available = true;
            $reason = 'available';

            // 1. Past dates and times check
            if ($dateCarbon->isPast() && !$isToday) {
                $available = false;
                $reason = 'past_date';
            } elseif ($isToday && $slotStart->lte($now)) {
                $available = false;
                $reason = 'past_time';
            }

            // 2. Exceeds clinic closing hours check
            if ($available && $slotEnd->gt($clinicClose)) {
                $available = false;
                $reason = 'exceeds_closing';
            }

            // 3. Conflict with existing appointments check (consecutive free slots check)
            if ($available) {
                foreach ($occupiedIntervals as $interval) {
                    // Check overlap: slotStart < interval.end AND slotEnd > interval.start
                    if ($slotStart->lt($interval['end']) && $slotEnd->gt($interval['start'])) {
                        $available = false;
                        $reason = 'booked';
                        break;
                    }
                }
            }

            $slots[] = [
                'value' => $t['value'],
                'text' => $t['text'],
                'available' => $available,
                'reason' => $reason,
            ];
        }

        return $slots;
    }

    /**
     * Check if a specific slot and duration is available for booking.
     */
    public function checkSlotAvailability(string $date, string $time, int $durationMinutes, ?int $ignoreAppointmentId = null): bool
    {
        $slotStart = Carbon::parse("{$date} {$time}");
        $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);
        $clinicClose = Carbon::parse("{$date} 17:00");

        // 1. Cannot book past dates/times
        if ($slotStart->isPast()) {
            return false;
        }

        // 2. Cannot exceed closing hours
        if ($slotEnd->gt($clinicClose)) {
            return false;
        }

        // 3. Overlap check with existing appointments
        $hasOverlap = $this->appointmentModel
            ->whereDate('scheduled_at', $date)
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->when($ignoreAppointmentId, function ($q) use ($ignoreAppointmentId) {
                $q->where('id', '!=', $ignoreAppointmentId);
            })
            ->get()
            ->contains(function ($app) use ($slotStart, $slotEnd) {
                $appStart = Carbon::parse($app->scheduled_at);
                $appDuration = $app->duration_minutes ?: 30;
                $appEnd = $appStart->copy()->addMinutes($appDuration);
                return $slotStart->lt($appEnd) && $slotEnd->gt($appStart);
            });

        return !$hasOverlap;
    }
}