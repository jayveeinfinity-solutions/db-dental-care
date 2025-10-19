<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PatientService;

class PatientController extends Controller
{
    public function __construct(
        protected PatientService $patientService
    ) {}

    public function index(Request $request) {
        $patients = $this->patientService->getPatients();

        return view('admin.patients.index', compact('patients'));
    }
}
