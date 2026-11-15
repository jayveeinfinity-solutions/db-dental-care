<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PatientResource;
use App\Http\Requests\LinkPatientRequest;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    public function __construct(
        protected PatientService $patientService
    ) {}

    public function index(Request $request) {
        $patients = $this->patientService->getPatients();

        $patients = PatientResource::collection($patients);

        $patients = collect($patients)
            ->map(function ($patientResource) {
                return json_decode(json_encode($patientResource->resolve()));
            });

        return view('admin.patients.index', compact('patients'));
    }

    // API ROUTES

    public function store(StorePatientRequest $request)
    {
        $patient = $this->patientService->create($request->validated());

        return response()->json([
            'message' => 'Patient record created successfully.',
            'data' => $patient
        ], Response::HTTP_CREATED);
    }

    public function update(UpdatePatientRequest $request, $id): JsonResponse
    {
        $patient = $this->patientService->updatePatient($id, $request->validated());

        return response()->json([
            'message' => 'Patient record updated successfully.',
            'patient' => $patient
        ], Response::HTTP_OK);
    }

    public function link(LinkPatientRequest $request): JsonResponse
    {
        $user = auth()->user();
        $patient = $this->patientService->linkPatientToUser($request->code, $user->id);

        return response()->json([
            'message' => 'Patient record linked successfully.',
            'patient' => $patient
        ], Response::HTTP_OK);
    }

    /**
     * Search patients by query for autocomplete
     */
    public function search(Request $request)
    {
        $q = $request->query('q');

        if (!$q) {
            return response()->json([]);
        }

        $patients = Patient::query()
            ->when($q, function ($query) use ($q) {
                $query->where('last_name', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('middle_name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            })
            ->limit(10)
            ->selectRaw("id, CONCAT(last_name, ', ', first_name) as name, code")
            ->get();

        return response()->json($patients);
    }
}
