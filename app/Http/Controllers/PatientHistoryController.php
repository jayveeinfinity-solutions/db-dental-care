<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\PatientHistory;
use Illuminate\Support\Facades\Storage;

class PatientHistoryController extends Controller
{
    public function view(PatientHistory $patientHistory) {
        $file_path = $patientHistory->file_path;
        $filename = Str::replace('patient_histories/', '', $file_path);
        $path = "{$file_path}";

        abort_unless(Storage::exists($path), 404);

        // OPTIONAL: add authorization check here
        // abort_unless(auth()->user()->can('viewPatientHistory'), 403);

        return response()->file(
            Storage::path($path),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]
        );
    }
}
