<?php

namespace App\Http\Requests;

use App\Models\Service;
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
            'appointment_id'    => ['nullable', 'exists:appointments,id'],
            'patient_id'        => ['required', 'exists:patients,id'],
            'notes'             => ['nullable', 'string'],
            'services'          => ['required', 'array', 'min:1'],
            'services.*.id'     => ['required', 'integer', 'exists:services,id'],
            'services.*.amount' => ['required', 'numeric', 'min:0'],
            'pdf_file'          => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    /**
     * Configure the validator instance.
     * Restrict PDF generation/upload strictly to Dental Certificates as per rev-1.md 4.2.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('pdf_file')) {
                $serviceIds = collect($this->input('services', []))->pluck('id')->filter();
                
                $hasDentalCertificate = Service::whereIn('id', $serviceIds)
                    ->where(function ($q) {
                        $q->where('name', 'like', '%Dental Certificate%')
                          ->orWhere('name', 'like', '%Certificate%');
                    })
                    ->exists();

                if (!$hasDentalCertificate) {
                    $validator->errors()->add(
                        'pdf_file', 
                        'PDF generation and document attachments are strictly restricted only to Dental Certificates.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'pdf_file.mimes' => 'The document must be a valid PDF file.',
            'pdf_file.max'   => 'The PDF document must not exceed 10MB in size.',
        ];
    }
}
