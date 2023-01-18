<?php

namespace App\Models\Collections;

use App\Models\Account;


class AccountsCollection
{
    private array $bankAccounts = [];

    public function __construct(array $bankAccounts = [])
    {
        foreach ($bankAccounts as $bankAccount) {
            $this->add($bankAccount);
        }
    }

    public function add(Account $bankAccount): void
    {
        $this->bankAccounts[] = $bankAccount;
    }

    public function getAll(): array
    {
        return $this->bankAccounts;
    }
}
