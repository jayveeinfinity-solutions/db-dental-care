<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    public function index() {
        $transactions = $this->transactionService->getTransactions();

        return view('admin.transactions.index', compact('transactions'));
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
