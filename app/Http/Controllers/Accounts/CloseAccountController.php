<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Rules\CodeMatchRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CloseAccountController extends Controller
{
    public function deleteAccount(Request $request, $id): RedirectResponse
    {
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $request->validate([
            'password' => 'required|current_password',
            'code' => ['required', new CodeMatchRule($codes)],
        ]);

        $userBankAccount = Account::find($id);

        if ($userBankAccount->balance > 0) {
            return redirect()->back()->with('error', 'You can only close an account with a zero balance.');
        }

        $userBankAccount->delete();

        $accountNumber = $userBankAccount->number;

        return redirect()->route('dashboard')->with(
            'success', 'Account ' . $accountNumber . ' closed successfully'
        );
    }
}
