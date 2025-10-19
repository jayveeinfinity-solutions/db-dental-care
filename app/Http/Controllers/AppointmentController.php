<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAppointmentRequest;

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
        $status = $request->query('status', 'all');
        $results = $this->appointmentService->getUserAppointments($status);

        return response()->json([
            'appointments' => $results
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create([
            'service_id' => $request->service_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function cancel(Appointment $appointment) {
        $appointment->update([
            'status' => 'cancelled'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment has been cancelled'
        ], Response::HTTP_OK);
    }

    public function updateStatus(Appointment $appointment, Request $request) {
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
