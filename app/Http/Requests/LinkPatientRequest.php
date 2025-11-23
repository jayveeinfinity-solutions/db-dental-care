<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class LinkPatientRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'exists:patients,code',
                function($attribute, $value, $fail) {
                    $patient = Patient::where('code', $value)->first();

                    if ($patient && $patient->user_id) {
                        $fail('This patient is already linked to another account.');
                    }
                }
            ]
        ];
    }
}
