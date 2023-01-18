<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Account;

class BalanceCheckRule implements Rule
{
    protected $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function passes($attribute, $value)
    {
        $account = Account::find(request()->input('account'));
        return $value * $this->price <= $account->balance;
    }

    public function message()
    {
        return 'Your account has insufficient funds';
    }
}
