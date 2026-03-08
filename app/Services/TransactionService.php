<?php

namespace App\Services;

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
        return $this->transactionModel->all();
    }
    
    public function getUserTransactions(int $patient_id) {
        return TransactionResource::collection(
            $this->transactionModel
                ->with(['appointment', 'patient', 'services'])
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

            // Save Transaction
            $transaction = Transaction::create([
                'appointment_id' => $data['appointment_id'] ?? null,
                'patient_id'     => $data['patient_id'],
                'total_amount'   => $totalAmount,
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
                Appointment::where('id', $data['appointment_id'])
                    ->update(['status' => 'completed']);
            }

            return $transaction->load('services'); // optional: eager load
        });
    }
}
