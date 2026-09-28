<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\PatientHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TransactionResource;
use App\Models\TransactionService as TransactionServiceModel;

class TransactionService
{
    public function __construct(
        protected Transaction $transactionModel,
        protected TransactionServiceModel $transactionServiceModel
    ) {}
    
    public function getTransactions() {
        return $this->transactionModel
            ->with(['appointment', 'patient', 'services.service', 'history'])
            ->latest()
            ->get();
    }
    
    public function getUserTransactions(int $patient_id) {
        return TransactionResource::collection(
            $this->transactionModel
                ->with(['appointment', 'patient', 'services.service', 'history'])
                ->where('patient_id', $patient_id)
                ->latest()
                ->get()
        );
    }

    public function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {

            // Calculate total amount
            $totalAmount = collect($data['services'])->sum(fn($s) => $s['amount']);

            $status = $data['status'] ?? 'in_progress';
            $checkedInAt = !empty($data['checked_in_at']) ? Carbon::parse($data['checked_in_at']) : now();
            $checkedOutAt = null;
            $durationSeconds = null;

            if ($status === 'completed') {
                $checkedOutAt = !empty($data['checked_out_at']) ? Carbon::parse($data['checked_out_at']) : now();
                $durationSeconds = $checkedInAt->diffInSeconds($checkedOutAt);
            }

            // Save Transaction
            $transaction = Transaction::create([
                'appointment_id'   => $data['appointment_id'] ?? null,
                'patient_id'       => $data['patient_id'],
                'total_amount'     => $totalAmount,
                'status'           => $status,
                'checked_in_at'    => $checkedInAt,
                'checked_out_at'   => $checkedOutAt,
                'duration_seconds' => $durationSeconds,
                'notes'            => $data['notes'] ?? null,
            ]);

            // Save transaction_services
            foreach ($data['services'] as $service) {
                TransactionServiceModel::create([
                    'transaction_id' => $transaction->id,
                    'service_id'     => $service['id'],
                    'quantity'       => 1,
                    'price'          => $service['amount'],
                    'subtotal'       => $service['amount'] * 1,
                ]);
            }

            // Save patient history if pdf_file exists
            if (!empty($data['pdf_file'])) {
                $path = $data['pdf_file']->store('patient_histories');

                PatientHistory::create([
                    'file_path'      => $path,
                    'transaction_id' => $transaction->id,
                    'patient_id'     => $data['patient_id'],
                    'description'    => $data['notes'] ?? null,
                ]);
            }

            // Update appointment status if appointment_id exists
            if (!empty($data['appointment_id'])) {
                $appStatus = $status === 'completed' ? 'completed' : 'approved';
                Appointment::where('id', $data['appointment_id'])
                    ->update(['status' => $appStatus]);
            }

            return $transaction->load(['patient', 'services.service', 'appointment', 'history']);
        });
    }

    public function checkoutTransaction(Transaction $transaction, array $data = []): Transaction
    {
        return DB::transaction(function () use ($transaction, $data) {
            $checkIn = $transaction->checked_in_at 
                ? Carbon::parse($transaction->checked_in_at) 
                : Carbon::parse($transaction->created_at);
            $checkOut = now();
            $durationSeconds = $checkIn->diffInSeconds($checkOut);

            $updateData = [
                'status'           => 'completed',
                'checked_out_at'   => $checkOut,
                'duration_seconds' => $durationSeconds,
            ];

            if (!empty($data['notes'])) {
                $updateData['notes'] = $data['notes'];
            }

            $transaction->update($updateData);

            if (!empty($data['pdf_file'])) {
                $path = $data['pdf_file']->store('patient_histories');

                PatientHistory::create([
                    'file_path'      => $path,
                    'transaction_id' => $transaction->id,
                    'patient_id'     => $transaction->patient_id,
                    'description'    => $data['notes'] ?? $transaction->notes ?? null,
                ]);
            }

            if ($transaction->appointment_id) {
                Appointment::where('id', $transaction->appointment_id)
                    ->update(['status' => 'completed']);
            }

            return $transaction->load(['patient', 'services.service', 'appointment', 'history']);
        });
    }

    public function checkInAppointment(Appointment $appointment): Transaction
    {
        return DB::transaction(function () use ($appointment) {
            $appointment->update(['status' => 'checked_in']);

            if ($appointment->transaction) {
                $appointment->transaction->update([
                    'status'        => 'in_progress',
                    'checked_in_at' => $appointment->transaction->checked_in_at ?? now(),
                ]);
                return $appointment->transaction->load(['appointment', 'patient', 'services.service', 'history']);
            }

            $services = $appointment->services()->exists() 
                ? $appointment->services 
                : ($appointment->service ? collect([$appointment->service]) : collect());

            $totalAmount = $services->sum(fn($s) => $s->price_max ?? $s->price_min ?? 0);

            $transaction = Transaction::create([
                'appointment_id'   => $appointment->id,
                'patient_id'       => $appointment->patient_id,
                'total_amount'     => $totalAmount,
                'status'           => 'in_progress',
                'checked_in_at'    => now(),
                'notes'            => $appointment->notes,
            ]);

            foreach ($services as $service) {
                $price = $service->price_max ?? $service->price_min ?? 0;
                TransactionServiceModel::create([
                    'transaction_id' => $transaction->id,
                    'service_id'     => $service->id,
                    'quantity'       => 1,
                    'price'          => $price,
                    'subtotal'       => $price,
                ]);
            }

            return $transaction->load(['appointment', 'patient', 'services.service', 'history']);
        });
    }
}
