<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientProcedure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PatientProcedureController extends Controller
{
    /**
     * Get historical procedures for a patient.
     */
    public function index(Patient $patient): JsonResponse
    {
        $procedures = $patient->procedures()
            ->with(['service', 'appointment'])
            ->orderBy('procedure_date', 'desc')
            ->get();

        return response()->json([
            'patient'    => $patient,
            'procedures' => $procedures
        ], Response::HTTP_OK);
    }

    /**
     * Store a new completed procedure with detailed medical history.
     */
    public function store(Request $request, Patient $patient): JsonResponse
    {
        $validated = $request->validate([
            'procedure_date'   => ['required', 'date'],
            'procedure_name'   => ['required', 'string', 'max:255'],
            'tooth_number'     => ['nullable', 'string', 'max:50'],
            'target_specifics' => ['required', 'string', 'max:255'],
            'amount'           => ['required', 'numeric', 'min:0'],
            'medical_history'  => ['nullable', 'string', 'max:5000'],
            'service_id'       => ['nullable', 'exists:services,id'],
            'appointment_id'   => ['nullable', 'exists:appointments,id'],
        ]);

        $procedure = $patient->procedures()->create($validated);

        return response()->json([
            'success'   => true,
            'message'   => 'Procedure record saved successfully.',
            'procedure' => $procedure->load(['service', 'appointment']),
        ], Response::HTTP_CREATED);
    }
}
