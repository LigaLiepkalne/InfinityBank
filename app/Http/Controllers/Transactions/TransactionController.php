<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;


class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $userBankAccounts = Account::where('user_id', auth()->id())->get();
        $transactions = Transaction::where('user_id', auth()->user()->id);

        if ($request->has('start-date') && $request->has('end-date')) {
            $transactions = $transactions->whereBetween('created_at', [$request->get('start-date'), $request->get('end-date')]);
        }

        if ($request->get('account')) {
            $transactions = $transactions->where(function($query) use ($request) {
                $query->where('recipient_account', $request->get('account'))
                    ->orWhere('sender_account', $request->get('account'));
            });
        }

        if ($request->get('sender') || $request->get('recipient')) {
            $transactions = $transactions->where(function($query) use ($request) {
                $query->where('sender_name', $request->get('sender'))
                    ->orWhere('recipient_name', $request->get('recipient'));
            });
        }

        $transactions = $transactions->latest()->get();

        return view('account-transactions.index', [
            'transactions' => $transactions,
            'userBankAccounts' => $userBankAccounts,
        ]);
    }

    /*
    //show auth user account-transactions
    public function index(Request $request): View
    {
        $userBankAccounts = Account::where('user_id', auth()->id())->get();
        $transactions = Transaction::where('user_id', auth()->user()->id);

            if (($request->has('start-date') && $request->has('end-date'))
            && !($request->get('recipient') || ($request->get('sender')))) {
                $all = $transactions->whereBetween('created_at', [$request->get('start-date'), $request->get('end-date')])
                    ->where('recipient_account', $request->get('account'))->orWhere('sender_account', $request->get('account'));

                $transactions = $all->where('user_id', auth()->id());
            }

        if ($request->has('start-date') && $request->has('end-date')) {
            $all = $transactions->whereBetween('created_at', [$request->get('start-date'), $request->get('end-date')])
                ->where('sender_name', $request->get('sender'))->orWhere('recipient_name', $request->get('recipient'));

            $transactions = $all->where('user_id', auth()->id());
        }

        $transactions = $transactions->latest()->get();

        return view('account-transactions.index', [
            'transactions' => $transactions,
            'userBankAccounts' => $userBankAccounts,
        ]);
    }
    */
/*
    public function filterByDate(Request $request): View
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->get();

        if (!empty($request->get('start_date')) && !empty($request->get('end_date'))) {
            $transactionsByDate = Transaction::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [$request->get('start_date'), $request->get('end_date')])
                ->get();
            return view('account-transactions.index', [
                'transactionsByDate' => $transactionsByDate,
            ]);
        }
    }
*/
            //$start_date = $request->input('start_date');
            //$end_date = $request->input('end_date');
            //$transactions = Transaction::whereBetween('created_at', [$start_date, $end_date])->get();


            /*
             * - Filtrēšanas opcija transākcijām (iespējamība atslatīt noteiktu konta numuru (account), datumu no-līdz)
             * , interneta bankas maksājumos, iespēja meklēt arī pēc saņēmēja (Piemēram: Saņēmējs Jānis Bērziņš, laika
             * posmā no 01.01.2021 līdz 01.01.2022. Maksimālais meklēšanas "range" ir 1 gads.
             */



        //show all account-transactions
        //show all account-transactions for a specific user
        //search for a specific transaction
        //show all account-transactions for a specific account
        //use the transaction service to get the account-transactions

}
