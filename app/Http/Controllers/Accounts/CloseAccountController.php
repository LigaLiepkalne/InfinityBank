<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Rules\CodeMatchRule;
use App\Rules\OwnAccountRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CloseAccountController extends Controller
{

    public function deleteAccountForm()
    {
        return view('accounts.delete');
    }
/*
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'account_id' => ['required', 'exists:accounts,id', new OwnAccountRule()],
            'password' => 'required|current_password',
        ]);

        $account = Account::find($request->get('account_id'));

        if ($account->balance > 0) {
            return redirect()->back()->with('error', 'You can only close an account with a zero balance.');
        }

        $account->delete();

        return redirect()->back()->with('success', 'Account closed successfully');
    }

    public function updateLabel(Request $request, $id): RedirectResponse
    {
        $userBankAccount = Account::find($id);  // use the ID to fetch the account
        $userBankAccount->label = $request->get('label');
        $userBankAccount->save();
        return redirect()->back();
    }
*/
    public function deleteAccount(Request $request, $id): RedirectResponse
    {
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        $request->validate([
            'password' => 'required|current_password',
            'code' => ['required', new CodeMatchRule($codes)],
        ]);

        $userBankAccount = Account::find($id);

        if ($userBankAccount->balance > 0) {
            return redirect()->back()->with('error', 'You can only close an account with a zero balance.');
        }

        $userBankAccount->delete();
        //redirect to /dashboard
        return redirect()->route('dashboard')->with('success', 'Account closed successfully');
    }

}
