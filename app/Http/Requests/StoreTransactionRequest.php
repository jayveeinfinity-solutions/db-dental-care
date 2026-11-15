<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
        if ($this->has('services') && is_string($this->services)) {
            $this->merge([
                'services' => json_decode($this->services, true),
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
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'patient_id'     => ['required', 'exists:patients,id'],
            'notes'          => ['nullable', 'string'],
            'services' => ['required', 'array'],
            'services.*.id' => ['required', 'integer', 'exists:services,id'],
            'services.*.amount' => ['required', 'numeric'],
            'pdf_file'       => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }
}
