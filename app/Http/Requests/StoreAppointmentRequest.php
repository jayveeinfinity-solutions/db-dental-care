<?php

namespace App\Http\Requests;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'patient_id' => ['nullable', 'exists:patients,id'],
            'date'       => ['required', 'date', 'after_or_equal:today'],
            'time'       => ['required', 'date_format:H:i'],
            'notes'      => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'Please select a service.',
            'service_id.exists' => 'Selected service is invalid.',
            
            'date.required' => 'Please choose a date.',
            'date.date' => 'Invalid date format.',
            'date.after_or_equal' => 'Appointment date must be today or later.',

            'time.required' => 'Please select a time for your appointment.',
            'time.date_format' => 'The time must be in a valid format (HH:mm).',
        ];
    }
}
