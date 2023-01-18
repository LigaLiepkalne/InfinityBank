<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;


class CodeMatchRule implements Rule
{
    private $codes;

    public function __construct($codes)
    {
        $this->codes = $codes;
    }

    public function passes($attribute, $value)
    {
        $codeIndex = request()->input('code_index');

        return $value === $this->codes[$codeIndex];
    }

    public function message()
    {
        return 'The code entered does not match';
    }
}
