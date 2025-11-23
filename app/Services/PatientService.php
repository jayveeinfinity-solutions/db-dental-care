<?php

namespace App\Services;

use Exception;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientService
{
    public function __construct(
        protected Patient $patientModel
    ) {}

    public function getPatients() {
        return $this->patientModel
            ->orderBy('last_name')
            ->get();
    }
    
    public function create(array $data): Patient
    {
        return DB::transaction(function () use ($data) {

            // Lock the table to safely read last ID
            $lastId = DB::table('patients')->lockForUpdate()->max('id') ?? 0;
            
            $data['code'] = 'PAT-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);

            // Create patient
            $patient = Patient::create($data);

            return $patient;
        });
    }

    public function updatePatient(int $id, array $data): Patient
    {
        $patient = Patient::findOrFail($id);

        $patient->update($data);

        return $patient;
    }

    public function linkPatientToUser(string $code, int $user_id)
    {
        return DB::transaction(function () use ($code, $user_id) {

            $patient = Patient::where('code', $code)
                ->lockForUpdate() // prevent race condition
                ->firstOrFail();

            // Make sure patient is not linked
            if ($patient->user_id) {
                throw new Exception('Patient is already linked to another account.');
            }

            // Make sure user doesn't already have a patient linked
            if (Patient::where('user_id', $user_id)->exists()) {
                throw new Exception('You already have a patient linked.');
            }

            $patient->user_id = $user_id;
            $patient->save();

            return $patient;
        });
    }
}