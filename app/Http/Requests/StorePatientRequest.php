<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'sex'             => ['required', 'in:male,female'],
            'birthdate'       => [
                'required',
                'date',
                'before:today',
                'after:' . now()->subYears(120)->format('Y-m-d'), // Not older than 120 years
            ],
            'contact_number'  => ['required', 'regex:/^(09|\+639)\d{9}$/'],
            'address'         => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'contact_number.regex' => 'Invalid PH number. Format: 09XXXXXXXXX or +639XXXXXXXXX'
        ];
    }
}
