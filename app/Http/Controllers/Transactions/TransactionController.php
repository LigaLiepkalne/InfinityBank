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
            $transactions = $transactions->whereDate('created_at', '>=', $request->get('start-date'))
                ->whereDate('created_at', '<=', $request->get('end-date'));
        }

        if ($request->get('account')) {
            $transactions = $transactions->where(function ($query) use ($request) {
                $query->where(function($query) use ($request){
                    $query->where('recipient_account', $request->get('account'))
                        ->where('type', 'Incoming Payment');
                })->orWhere(function($query) use ($request){
                    $query->where('sender_account', $request->get('account'))
                        ->where('type', 'Outgoing Payment');
                });
            });
        }

        if ($request->get('sender') || $request->get('recipient')) {
            $transactions = $transactions->where(function ($query) use ($request) {
                $sender = $request->get('sender');
                $recipient = $request->get('recipient');

                if (!empty($sender)) {
                    $name = explode(' ', $sender);
                    $query->where(function ($q) use ($name) {
                        $q->where('sender_name', $name[0]);
                        if (count($name) > 1) {
                            $q->orWhere('sender_surname', $name[1]);
                        }
                    });
                }
                if (!empty($recipient)) {
                    $name = explode(' ', $recipient);
                    $query->orWhere(function ($q) use ($name) {
                        $q->where('recipient_name', $name[0]);
                        if (count($name) > 1) {
                            $q->orWhere('recipient_surname', $name[1]);
                        }
                    });
                }
            });
        }

        return view('account-transactions.index', [
            'transactions' => $transactions->latest()->get(),
            'userBankAccounts' => $userBankAccounts,
        ]);
    }
}
