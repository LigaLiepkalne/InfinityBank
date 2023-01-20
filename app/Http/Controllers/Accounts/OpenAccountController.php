<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpenAccountController extends Controller
{
    public function createAccountForm(): View
    {
        $currencies = [
            'USD', 'EUR', 'JPY', 'GBP', 'CHF',
            'AUD', 'CAD', 'HKD', 'SGD', 'KRW',
            'CNY', 'INR', 'TWD', 'THB', 'BRL',
            'MXN', 'RUB', 'ZAR', 'SEK', 'IDR'
        ];

        return view('accounts.create', [
            'currencies' => $currencies,
        ]);
    }

    public function storeAccount(Request $request): RedirectResponse
    {
        $request->validate([
            'currency' => 'required',
            'balance' => 'required|numeric|min:0',
            'password' => 'required|current_password',
        ]);

        $account = Account::create([
            'user_id' => auth()->user()->id,
            'number' => 'LV' . str_pad((string)rand(1, 9999999999), 17, '0', STR_PAD_LEFT),
            'label' => $request->get('label'),
            'balance' => $request->get('balance'),
            'currency' => $request->get('currency'),
        ]);

        $accountNumber = $account->number;

        return redirect()->back()->with(
            'success', 'Account created successfully. Your account number is: ' . $accountNumber
        );
    }
}
