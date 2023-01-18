<?php

namespace App\Rules;

use App\Models\CodeCard;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class TransferValidationRules implements Rule
{

    public function passes($attribute, $value)
    {

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        switch ($attribute) {
            case 'code':
                $codeIndex = request()->input('code_index');
                $codes = request()->session()->get('codes');
                return $value === $codes[$codeIndex];
            case 'from_account':
                $fromAccount = Account::where('number', $value)->first();
                return $fromAccount->balance >= request()->input('amount');
            default:
                return false;
        }
    }

    public function message()
    {
        switch ($this->attribute) {
            case 'password':
                return 'The current password is incorrect.';
            case 'code':
                return 'The code entered does not match.';
            case 'from_account':
                return 'Insufficient funds.';
            default:
                return '';
        }
    }

}
