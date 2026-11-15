<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Services\AppointmentService;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\CancelAppointmentRequest;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $status = $request->query('status', 'all');
        $results = $this->appointmentService->getUserAppointments($user, $status);

        return response()->json([
            'appointments' => $results
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {   
        $user_id = auth()->id();

        // Resolve patient_id: either from request or linked to current user
        $patient_id = $request->patient_id;
        if (!$patient_id) {
            $patient = auth()->user()->patient;
            if (!$patient) {
                return response()->json([
                    'message' => 'No patient record linked to your account.'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $patient_id = $patient->id;
        }

        $data = $request->validated();
        $scheduled_at = Carbon::parse("{$data['date']} {$data['time']}");

        $appointment = Appointment::create([
            'service_id'   => $data['service_id'],
            'user_id'      => $user_id,
            'patient_id'   => $patient_id,
            'scheduled_at' => $scheduled_at,
            'notes'        => $request->notes ?? null,
            'status'       => 'pending',
        ]);

        return response()->json([
            'message'     => 'Appointment booked successfully!',
            'appointment' => $appointment,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): JsonResponse
    {
        $appointment = $appointment->load(['service', 'patient', 'bookedBy', 'transaction.services.service']);
        return response()->json($appointment, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(CancelAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $this->appointmentService->cancel(
            $appointment,
            $request->reason,
            $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Appointment has been cancelled'
        ], Response::HTTP_OK);
    }

    public function updateStatus(Appointment $appointment, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,cancelled,completed'
        ]);

        DB::transaction(function () use ($appointment, $validated) {

            $appointment->update(['status' => $validated['status']]);

            // If status is completed, create a transaction
            if ($validated['status'] === 'completed') {

                // Create transaction if it doesn't exist yet
                $transaction = $appointment->transaction ?? $appointment->transaction()->create([
                    'total_amount' => 0,
                ]);

                // Attach all appointment services to the transaction
                $transaction->services()->create([
                    'service_id' => $appointment->service->id,
                    'quantity' => 1,
                    'price' => $appointment->service->price_max,
                    'subtotal' => $appointment->service->price_max,
                ]);

                // Recalculate total
                $transaction->total_amount = $transaction->services->sum('subtotal');
                $transaction->save();
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Appointment has been updated'
        ], Response::HTTP_OK);
    }
}
