<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\TransactionService;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $patient_id = $request->user()?->patient->id;
        $results = $this->transactionService->getUserTransactions($patient_id);

        return response()->json([
            'transactions' => $results
        ], Response::HTTP_OK);
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->transactionService->createTransaction($request->validated());

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }
}
