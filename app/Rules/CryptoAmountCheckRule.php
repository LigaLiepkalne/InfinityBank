<?php

namespace App\Rules;

use App\Models\CryptoPortfolio;
use Illuminate\Contracts\Validation\Rule;

class CryptoAmountCheckRule implements Rule
{
    protected $request;
    protected $symbol;

    public function __construct($request, $symbol)
    {
        $this->request = $request;
        $this->symbol = $symbol;
    }

    public function passes($attribute, $value)
    {
        $amount = CryptoPortfolio::where('bank_account_id', $this->request->get('account'))->where('symbol', $this->symbol)->value('amount');
        return $value <= $amount;
    }

    public function message()
    {
        return 'You do not have enough crypto in selected account.';
    }
}
