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

        $serviceIds = $request->input('service_ids', []);
        if (empty($serviceIds) && !empty($data['service_id'])) {
            $serviceIds = [(int) $data['service_id']];
        }
        $primaryServiceId = $serviceIds[0] ?? $data['service_id'] ?? null;

        $appointment = Appointment::create([
            'service_id'   => $primaryServiceId,
            'user_id'      => $user_id,
            'patient_id'   => $patient_id,
            'scheduled_at' => $scheduled_at,
            'notes'        => $request->notes ?? null,
            'status'       => 'pending',
        ]);

        if (!empty($serviceIds)) {
            $appointment->services()->sync($serviceIds);
        }

        return response()->json([
            'message'     => 'Appointment booked successfully!',
            'appointment' => $appointment->load('services', 'service'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): JsonResponse
    {
        $appointment = $appointment->load(['service', 'services', 'patient', 'bookedBy', 'transaction.services.service']);
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
            'status' => 'required|string|in:pending,approved,checked_in,cancelled,completed'
        ]);

        DB::transaction(function () use ($appointment, $validated) {
            if ($validated['status'] === 'checked_in') {
                app(\App\Services\TransactionService::class)->checkInAppointment($appointment);
                return;
            }

            $appointment->update(['status' => $validated['status']]);

            // If status is completed, create or finalize a transaction
            if ($validated['status'] === 'completed') {
                if ($appointment->transaction && $appointment->transaction->status === 'in_progress') {
                    app(\App\Services\TransactionService::class)->checkoutTransaction($appointment->transaction);
                } else {
                    $checkIn = $appointment->scheduled_at ? Carbon::parse($appointment->scheduled_at) : now();
                    $checkOut = now();
                    $duration = $checkIn->diffInSeconds($checkOut);

                    // Create transaction if it doesn't exist yet
                    $transaction = $appointment->transaction ?? $appointment->transaction()->create([
                        'patient_id'       => $appointment->patient_id,
                        'total_amount'     => 0,
                        'status'           => 'completed',
                        'checked_in_at'    => $checkIn,
                        'checked_out_at'   => $checkOut,
                        'duration_seconds' => $duration,
                    ]);

                    $transaction->update([
                        'status'           => 'completed',
                        'checked_out_at'   => $transaction->checked_out_at ?? $checkOut,
                        'duration_seconds' => $transaction->duration_seconds ?? $duration,
                    ]);

                    $services = $appointment->services()->exists() 
                        ? $appointment->services 
                        : ($appointment->service ? collect([$appointment->service]) : collect());

                    if ($transaction->services()->count() === 0) {
                        foreach ($services as $service) {
                            $transaction->services()->create([
                                'service_id' => $service->id,
                                'quantity'   => 1,
                                'price'      => $service->price_max ?? $service->price_min ?? 0,
                                'subtotal'   => $service->price_max ?? $service->price_min ?? 0,
                            ]);
                        }
                    }

                    // Recalculate total
                    $transaction->total_amount = $transaction->services->sum('subtotal');
                    $transaction->save();
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Appointment has been updated'
        ], Response::HTTP_OK);
    }
}
