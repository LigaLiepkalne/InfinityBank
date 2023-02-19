<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\CodeMatchRule;
use App\Rules\RecipientExistsRule;
use App\Services\CurrencyExchangeRate\CurrencyApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AccountOperationsController extends Controller
{
    private CurrencyApiService $currencyApiService;

    public function __construct(CurrencyApiService $currencyApiService)
    {
        $this->currencyApiService = $currencyApiService;
    }

    public function updateLabel(Request $request, $id): RedirectResponse
    {
        $userBankAccount = Account::find($id);
        $userBankAccount->label = $request->get('label');
        $userBankAccount->save();
        return redirect()->back();
    }

    public function showTransferForm(): View
    {
        $userBankAccounts = Account::where('user_id', auth()->id())->get();
        $exchangeRates = $this->currencyApiService->getExchangeRates();

        return view('accounts.transfer', [
            'userBankAccounts' => $userBankAccounts,
            'exchangeRates' => $exchangeRates
        ]);
    }

    public function transfer(Request $request): RedirectResponse
    {
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $request->validate([
            'recipient' => ['required', 'string',  new RecipientExistsRule()],
            'from_account' => ['required', Rule::exists('accounts', 'number')->where(function ($query) {
                $query->where('user_id', auth()->id());
            })],
            'to_account' => 'required|exists:accounts,number|different:from_account',
            'amount' => 'required|numeric|min:0.01|max:' . Account::where('number', $request->get('from_account'))->value('balance'),
            'password' => 'required|current_password',
            'details' => 'required',
            'code' => ['required', new CodeMatchRule($codes)],
        ]);

        try {
            DB::transaction(function () use ($request) {

                $fromCurrency = Account::where('number', $request->get('from_account'))->value('currency');
                $toCurrency = Account::where('number', $request->get('to_account'))->value('currency');

                $exchangeFrom = $this->currencyApiService->getExchangeRate($fromCurrency);
                $exchangeTo = $this->currencyApiService->getExchangeRate($toCurrency);

                if($fromCurrency === 'EUR') {
                    $amount = $request->get('amount') * $exchangeTo;
                } else {
                    $amount = $request->get('amount') / $exchangeFrom;
                }

                Account::where('number', $request->get('from_account'))->decrement('balance', $request->get('amount'));
                Account::where('number', $request->get('to_account'))->increment('balance', $amount);

                Transaction::create([
                    'user_id' => auth()->id(),
                    'received_currency' => Account::where('number', $request->get('to_account'))->value('currency'),
                    'sent_currency' => Account::where('number', $request->get('from_account'))->value('currency'),
                    'conversion_rate' => $exchangeFrom / $exchangeTo,
                    'received_amount' => $amount,
                    'sent_amount' => -$request->get('amount'),
                    'recipient_account' => $request->get('to_account'),
                    'sender_account' => $request->get('from_account'),
                    'sender_name' => auth()->user()->name,
                    'sender_surname' => auth()->user()->surname,
                    'recipient_name' => User::all()->where('id', Account::where('number', $request->get('to_account'))
                        ->value('user_id'))
                        ->first()->name,
                    'recipient_surname' => User::all()->where('id', Account::where('number', $request->get('to_account'))
                        ->value('user_id'))
                        ->first()->surname,
                    'details' => $request->get('details'),
                    'type' => 'Outgoing Payment',
                ]);

                Transaction::create([
                    'user_id' => Account::where('number', $request->get('to_account'))->value('user_id'),
                    'received_currency' => Account::where('number', $request->get('to_account'))->value('currency'),
                    'sent_currency' => Account::where('number', $request->get('from_account'))->value('currency'),
                    'conversion_rate' => $exchangeFrom / $exchangeTo,
                    'received_amount' => $amount,
                    'sent_amount' => -$request->get('amount'),
                    'recipient_account' => $request->get('to_account'),
                    'sender_account' => $request->get('from_account'),
                    'sender_name' => auth()->user()->name,
                    'sender_surname' => auth()->user()->surname,
                    'recipient_name' => User::all()->where('id', Account::where('number', $request->get('to_account'))
                        ->value('user_id'))
                        ->first()->name,
                    'recipient_surname' => User::all()->where('id', Account::where('number', $request->get('to_account'))
                        ->value('user_id'))
                        ->first()->surname,
                    'details' => $request->get('details'),
                    'type' => 'Incoming Payment',
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->back()->with('success', 'Payment successful');
    }

    public function showRecipientCurrency(Request $request): JsonResponse
    {
        $currency = DB::table('accounts')->where('number', $request->account)->value('currency');
        return response()->json(['currency' => $currency]);
    }
}
