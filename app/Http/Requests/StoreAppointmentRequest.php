<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Services\AppointmentService;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Support backward compatibility: if single service_id provided, wrap into service_ids array
        if ($this->has('service_id') && !$this->has('service_ids')) {
            $this->merge([
                'service_ids' => [(int) $this->service_id]
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_ids'   => ['required', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'service_id'    => ['nullable'],
            'patient_id'    => ['nullable', 'exists:patients,id'],
            'date'          => ['required', 'date', 'after_or_equal:today'],
            'time'          => ['required', 'date_format:H:i'],
            'notes'         => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $date = $this->input('date');
            $time = $this->input('time');
            $serviceIds = (array) $this->input('service_ids', []);

            if (!$date || !$time || empty($serviceIds)) {
                return;
            }

            try {
                $scheduledAt = Carbon::parse("{$date} {$time}");
            } catch (\Exception $e) {
                $validator->errors()->add('time', 'Invalid date and time combination.');
                return;
            }

            // 1. Strict past-booking check
            if ($scheduledAt->isPast()) {
                $validator->errors()->add('time', 'The appointment date and time cannot be in the past. Please select a future time slot.');
                return;
            }

            // 2. Strict double-booking and consecutive slot availability check
            $appointmentService = app(AppointmentService::class);
            $duration = $appointmentService->calculateDuration($serviceIds);

            $isAvailable = $appointmentService->checkSlotAvailability($date, $time, $duration);
            if (!$isAvailable) {
                $validator->errors()->add('time', "The selected time slot ({$time}) is unavailable or conflicts with another booking for the required {$duration}-minute duration. Please choose another time slot.");
            }
        });
    }

    public function messages(): array
    {
        return [
            'service_ids.required' => 'Please select at least one service.',
            'service_ids.min'      => 'Please select at least one service.',
            'service_ids.*.exists' => 'One or more selected services are invalid.',
            
            'date.required'        => 'Please choose a date.',
            'date.date'            => 'Invalid date format.',
            'date.after_or_equal'  => 'Appointment date must be today or later.',

            'time.required'        => 'Please select a time for your appointment.',
            'time.date_format'     => 'The time must be in a valid format (HH:mm).',
        ];
    }
}
