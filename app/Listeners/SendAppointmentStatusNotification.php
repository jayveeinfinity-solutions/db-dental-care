<?php

namespace App\Listeners;

use App\Events\AppointmentStatusChanged;
use App\Notifications\AppointmentStatusNotification;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendAppointmentStatusNotification
{
    /**
     * Handle the event.
     */
    public function handle(AppointmentStatusChanged $event): void
    {
        $status = $event->newStatus;

        // Only notify on approved or cancelled as per rev-1.md 4.1
        if (!in_array($status, ['approved', 'cancelled'])) {
            return;
        }

        $appointment = $event->appointment->loadMissing(['bookedBy', 'patient.user', 'services', 'service']);

        // Determine recipient user
        $recipient = $appointment->bookedBy ?? $appointment->patient?->user;

        if (!$recipient || empty($recipient->email)) {
            Log::info("No valid email found to send appointment {$status} notification for appointment #{$appointment->id}.");
            return;
        }

        try {
            $recipient->notify(new AppointmentStatusNotification($appointment, $status));
            Log::info("Appointment {$status} notification sent successfully to {$recipient->email} for appointment #{$appointment->id}.");
        } catch (Throwable $e) {
            // Log warning without disrupting admin or user transaction flow
            Log::warning("Failed to send appointment {$status} notification to {$recipient->email}: " . $e->getMessage());
        }
    }
}
