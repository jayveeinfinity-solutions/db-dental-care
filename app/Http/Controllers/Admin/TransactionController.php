<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    public function index() {
        $transactions = $this->transactionService->getTransactions();

        return view('admin.transactions.index', compact('transactions'));
    }
}
