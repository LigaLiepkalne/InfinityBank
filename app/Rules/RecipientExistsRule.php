<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class RecipientExistsRule implements Rule
{
    public function passes($attribute, $value)
    {
        $recipient = explode(' ',$value);
        if(count($recipient)>1){
            $name = $recipient[0];
            $surname = $recipient[1];
            $user = User::where('name', $name)->where('surname', $surname)->first();
            return $user !== null;
        }
        return false;
    }

    public function message()
    {
        return 'Invalid recipient name or surname.';
    }
}
