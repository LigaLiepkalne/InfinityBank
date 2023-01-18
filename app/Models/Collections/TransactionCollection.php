<?php

namespace App\Models\Collections;

use App\Models\Transaction;

class TransactionCollection
{
    private array $transactions = [];

    public function __construct(array $transactions = [])
    {
        foreach ($transactions as $transaction) {
            $this->add($transaction);
        }
    }

    public function add(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
    }

    public function getAll(): array
    {
        return $this->transactions;
    }
}
