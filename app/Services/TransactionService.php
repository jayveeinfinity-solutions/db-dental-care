<?php

namespace App\Services;

use App\Models\Transaction;
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
}