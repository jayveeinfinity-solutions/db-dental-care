<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Services\AppointmentService;
use App\Events\AppointmentStatusChanged;
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
     * Get available slots for a specific date and duration/services.
     */
    public function availableSlots(Request $request): JsonResponse
    {
        $date = $request->query('date', Carbon::today()->toDateString());
        $serviceIds = $request->query('service_ids', []);

        if (is_string($serviceIds)) {
            $serviceIds = array_filter(explode(',', $serviceIds));
        }

        $duration = (int) $request->query('duration', 0);
        if ($duration <= 0 && !empty($serviceIds)) {
            $duration = $this->appointmentService->calculateDuration((array) $serviceIds);
        } elseif ($duration <= 0) {
            $duration = 30;
        }

        $slots = $this->appointmentService->getAvailableSlots($date, $duration);

        return response()->json([
            'date'            => $date,
            'duration'        => $duration,
            'slots'           => $slots,
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
        $serviceIds = (array) $data['service_ids'];
        $durationMinutes = $this->appointmentService->calculateDuration($serviceIds);
        $scheduled_at = Carbon::parse("{$data['date']} {$data['time']}");

        $appointment = DB::transaction(function () use ($data, $serviceIds, $durationMinutes, $scheduled_at, $user_id, $patient_id, $request) {
            $createdAppointment = Appointment::create([
                'service_id'       => $serviceIds[0] ?? null, // primary service for backwards compatibility
                'duration_minutes' => $durationMinutes,
                'user_id'          => $user_id,
                'patient_id'       => $patient_id,
                'scheduled_at'     => $scheduled_at,
                'notes'            => $request->notes ?? null,
                'status'           => 'pending',
            ]);

            // Sync all selected services into appointment_services pivot table
            $createdAppointment->services()->sync($serviceIds);

            return $createdAppointment;
        });

        return response()->json([
            'message'     => 'Appointment booked successfully!',
            'appointment' => $appointment->load(['services', 'service', 'patient']),
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
            'status' => 'required|string|in:pending,approved,cancelled,completed'
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $validated['status'];

        DB::transaction(function () use ($appointment, $newStatus) {

            $appointment->update(['status' => $newStatus]);

            // If status is completed, create a transaction
            if ($newStatus === 'completed') {

                // Create transaction if it doesn't exist yet
                $transaction = $appointment->transaction ?? $appointment->transaction()->create([
                    'total_amount' => 0,
                    'patient_id'   => $appointment->patient_id,
                ]);

                // Ensure all appointment services are attached to transaction
                $appointmentServices = $appointment->services->isNotEmpty()
                    ? $appointment->services
                    : ($appointment->service ? collect([$appointment->service]) : collect());

                foreach ($appointmentServices as $svc) {
                    $alreadyAttached = $transaction->services()->where('service_id', $svc->id)->exists();
                    if (!$alreadyAttached) {
                        $price = $svc->price_max ?: ($svc->price_min ?: 0);
                        $transaction->services()->create([
                            'service_id' => $svc->id,
                            'quantity'   => 1,
                            'price'      => $price,
                            'subtotal'   => $price,
                        ]);
                    }
                }

                // Recalculate total
                $transaction->total_amount = $transaction->services->sum('subtotal');
                $transaction->save();
            }
        });

        // Fire status changed event
        event(new AppointmentStatusChanged($appointment, $oldStatus, $newStatus));

        return response()->json([
            'success' => true,
            'message' => 'Appointment has been updated'
        ], Response::HTTP_OK);
    }
}
