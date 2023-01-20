<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class OwnAccountRule implements Rule
{
    public function passes($attribute, $value)
    {
        $account = Account::find($value);

        if ($account->user_id == Auth::id()) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'Transfers can only be made from your own account.';
    }
}
