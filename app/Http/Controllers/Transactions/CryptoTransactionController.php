<?php

namespace App\Http\Controllers\Transactions;

use App\Models\Account;
use App\Models\CryptoTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CryptoTransactionController
{
    public function index(Request $request): View
    {
        $userBankAccounts = Account::where('user_id', auth()->id())->get();
        $transactions = CryptoTransaction::whereIn('bank_account_id', $userBankAccounts
            ->pluck('id'));

        if ($request->has('start-date') && $request->has('end-date')) {
            $transactions = $transactions->whereDate('created_at', '>=', $request->get('start-date'))
                ->whereDate('created_at', '<=',$request->get('end-date'));
        }

        $selectedAccount = Account::where('number', $request->get('account'))->get();
        if ($request->has('account')) {
            $id = $selectedAccount->pluck('id')->first();
            $transactions = $transactions->where('bank_account_id', $id);
        }

        return view('crypto-transactions.index', [
            'transactions' => $transactions->latest()->get(),
            'userBankAccounts' => $userBankAccounts,
        ]);
    }
}
