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
        $transactions = CryptoTransaction::whereIn('bank_account_id', $userBankAccounts->pluck('id'))->latest()->get();

       if($request->has('start-date') && $request->has('end-date')) {
            $transactions = $transactions->whereBetween('created_at', [$request->get('start-date'), $request->get('end-date')]);
      }

        $selectedAccount = Account::where('number', $request->get('account'))->get();
        if ($request->has('account')) {
            $id = $selectedAccount->pluck('id')->first();
            $transactions = $transactions->where('bank_account_id', $id);
        }

/*
       $selectedAccount = Account::where('number', $request->get('account'))->first();
       $id = $selectedAccount->id;

       if($request->has('account')) {
          $transactions = $transactions->where('bank_account_id', $id);
        }
*/
/*
        $selectedAccount = Account::where('number', $request->get('account'))->get();
        if ($selectedAccount->isNotEmpty()) {
            $id = $selectedAccount->pluck('id')->first();
            $transactions = $transactions->where('bank_account_id', $id);
        }
*/
/*
        if($request->has('account')) {
            $selectedAccount = Account::where('number', $request->get('account'))->first();
            $id = $selectedAccount->id;
            $transactions = $transactions->where('bank_account_id', $id);
        }

        var_dump($transactions);
        */
        return view('crypto-transactions.index', [
            'transactions' => $transactions,
            'userBankAccounts' => $userBankAccounts,
        ]);

    }

}

//Filtrēšanas opcija transākcijām (iespējamība atslatīt noteiktu konta numuru (account), datumu no-līdz),


