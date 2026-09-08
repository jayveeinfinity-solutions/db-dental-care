<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
        public string $status
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusTitle = ucfirst($this->status);
        $patientName = $this->appointment->patient?->full_name ?? 'Valued Patient';
        $date = $this->appointment->formatted_date;
        $services = $this->appointment->services->isNotEmpty()
            ? $this->appointment->services->pluck('name')->join(', ')
            : ($this->appointment->service?->name ?? 'Dental Consultation / Treatment');

        $message = (new MailMessage)
            ->subject("Appointment {$statusTitle} - DB Dental Care")
            ->greeting("Hello, {$patientName}!");

        if ($this->status === 'approved') {
            $message->line("Your dental appointment scheduled for **{$date}** has been **APPROVED**.")
                ->line("**Requested Services:** {$services}")
                ->line("Please arrive 10-15 minutes prior to your scheduled time.")
                ->action('View My Appointments', url('/appointments'))
                ->line('Thank you for trusting DB Dental Care with your oral health!');
        } elseif ($this->status === 'cancelled') {
            $reason = $this->appointment->cancellation_reason ?: 'No specific reason provided';
            $message->line("We regret to inform you that your dental appointment for **{$date}** has been **CANCELLED**.")
                ->line("**Reason:** {$reason}")
                ->line("**Services:** {$services}")
                ->action('Book New Appointment', url('/services'))
                ->line('If you have any questions or would like to reschedule, please contact our clinic.');
        } else {
            $message->line("Your appointment status has been updated to **{$statusTitle}**.")
                ->action('View Appointments', url('/appointments'));
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'status'         => $this->status,
            'scheduled_at'   => $this->appointment->scheduled_at,
            'message'        => "Your appointment status was updated to {$this->status}.",
        ];
    }
}
