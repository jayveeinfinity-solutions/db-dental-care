<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    public function index() {
        $transactions = $this->transactionService->getTransactions();

        $transactions = TransactionResource::collection($transactions);

        $transactions = collect($transactions)
            ->map(function ($transactionResource) {
                return json_decode(json_encode($transactionResource->resolve()));
            });

        return view('admin.transactions.index', compact('transactions'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->transactionService->createTransaction($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Transaction saved successfully!',
            'transaction' => new TransactionResource($transaction)
        ]);
    }

    public function checkout(\Illuminate\Http\Request $request, \App\Models\Transaction $transaction)
    {
        $validated = $request->validate([
            'notes'    => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $transaction = $this->transactionService->checkoutTransaction($transaction, $validated);

        return response()->json([
            'success'            => true,
            'message'            => 'Patient checked out successfully!',
            'transaction'        => new TransactionResource($transaction),
            'duration_formatted' => $transaction->formatted_duration,
            'duration_seconds'   => $transaction->duration_seconds,
        ]);
    }

    public function checkIn(\App\Models\Appointment $appointment)
    {
        $transaction = $this->transactionService->checkInAppointment($appointment);

        return response()->json([
            'success'     => true,
            'message'     => 'Patient checked in successfully! Timer is now running.',
            'transaction' => new TransactionResource($transaction),
        ]);
    }
}
