<?php

namespace App\Composers;

use App\Models\CodeCard;
use Illuminate\Contracts\View\View;

class CodeCardComposer
{

    public function compose(View $view)
    {
        /*
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));
        $view->with(compact('codes','codeIndex'));
        */

        if (auth()->check()) {
            $codeCard = CodeCard::where('user_id', auth()->id())->first();
            if($codeCard) {
                $codes = json_decode($codeCard->codes);
                $codes = array_combine(range(1, count($codes)), $codes);
                $codeIndex = rand(1, count($codes));
                $view->with(compact('codes','codeIndex'));
            }
        }
        else {
            $view->with(['codes' => [], 'codeIndex' => null]);
        }
    }

}
