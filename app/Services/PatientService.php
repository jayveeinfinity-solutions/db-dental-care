<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientService
{
    public function __construct(
        protected Patient $patientModel
    ) {}

    public function countPatient() {
        return $this->patientModel->count();
    }

    public function getPatients($filter = 'all') {
        return $this->patientModel
            ->when($filter === 'today', function($query) {
                $query->whereDate('created_at', Carbon::today())
                      ->orWhereHas('appointments', fn($q) => $q->whereDate('scheduled_at', Carbon::today()));
            })
            ->when($filter === 'this_week', function($query) {
                $start = Carbon::now()->startOfWeek()->startOfDay();
                $end = Carbon::now()->endOfWeek()->endOfDay();
                $query->whereBetween('created_at', [$start, $end])
                      ->orWhereHas('appointments', fn($q) => $q->whereBetween('scheduled_at', [$start, $end]));
            })
            ->when($filter === 'this_month', function($query) {
                $start = Carbon::now()->startOfMonth()->startOfDay();
                $end = Carbon::now()->endOfMonth()->endOfDay();
                $query->whereBetween('created_at', [$start, $end])
                      ->orWhereHas('appointments', fn($q) => $q->whereBetween('scheduled_at', [$start, $end]));
            })
            ->orderBy('last_name')
            ->get();
    }
    
    public function create(array $data): Patient
    {
        return DB::transaction(function () use ($data) {

            // Lock the table to safely read last ID
            $lastId = DB::table('patients')->lockForUpdate()->max('id') ?? 0;
            
            // Globally standardized PX abbreviation for patient code
            $data['code'] = 'PX-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);

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

            // Allow matching PX- or legacy PAT-
            $patient = Patient::where('code', $code)
                ->orWhere('code', str_replace('PAT-', 'PX-', $code))
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