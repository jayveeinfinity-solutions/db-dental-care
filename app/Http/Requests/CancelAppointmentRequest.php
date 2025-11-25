<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $appointment = $this->route('appointment');
        $user = $this->user();

        // Ensure user is authenticated
        if (!$user) {
            return false;
        }

        // Allow if user is the creator OR has permission to cancel
        return $appointment && (
            $appointment->user_id === $user->id ||
            $user->can('cancel-appointments') ||
            !$user->hasRole('patient')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
