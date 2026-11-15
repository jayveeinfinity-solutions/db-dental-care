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

    protected function prepareForValidation()
    {
        if ($this->has('service_ids') && is_string($this->service_ids)) {
            $this->merge([
                'service_ids' => json_decode($this->service_ids, true),
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
            'service_id'    => ['nullable', 'exists:services,id'],
            'service_ids'   => ['required_without:service_id', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'patient_id'    => ['nullable', 'exists:patients,id'],
            'date'          => ['required', 'date', 'after:today'],
            'time'          => ['required', 'date_format:H:i'],
            'notes'         => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'Please select at least one service.',
            'service_ids.required_without' => 'Please select at least one service.',
            'service_ids.min' => 'Please select at least one service.',
            'service_ids.*.exists' => 'Selected service is invalid.',
            
            'date.required' => 'Please choose a date.',
            'date.date' => 'Invalid date format.',
            'date.after' => 'Appointment date must be tomorrow or later. Today and past dates cannot be booked.',

            'time.required' => 'Please select a time for your appointment.',
            'time.date_format' => 'The time must be in a valid format (HH:mm).',
        ];
    }
}
