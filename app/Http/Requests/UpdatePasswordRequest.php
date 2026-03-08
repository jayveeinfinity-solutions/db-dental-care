<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'current_password' => ['nullable', 'string'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }
    public function messages()
    {
        return [
            'current_password.string' => 'The current password must be a valid string.',
            
            'password.required' => 'Please enter your new password.',
            'password.min' => 'Your new password must be at least :min characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
