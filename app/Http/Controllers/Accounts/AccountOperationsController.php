<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\CryptoPortfolio;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Crypto\CoinMarketCapCryptoRepository;
use App\Repositories\CurrencyApiRepository;
use App\Rules\CodeMatchRule;
use App\Services\AccountOperationsService;
use App\Services\Crypto\CryptoService;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

//use App\Rules\OwnAccountRule;
//use App\Rules\TransferValidationRules;


class AccountOperationsController extends Controller
{
    private AccountOperationsService $bankAccountOperationService;
    private CryptoService $cryptoService;

    public function __construct(AccountOperationsService $bankAccountOperationService, CryptoService $cryptoService)
    {
        $this->bankAccountOperationService = $bankAccountOperationService;
        $this->cryptoService = $cryptoService;
    }

/*
    public function showDepositWithdrawForm(): View
    {
        $userBankAccounts = $this->bankAccountOperationService->getUserBankAccounts();
        //dd($userBankAccounts->getAll());
        return view('deposit-withdraw', [
            'userBankAccounts' => $userBankAccounts->getAll()
        ]);
    }
*/

    /*
    public function editLabel(Request $request, $number): RedirectResponse
    {
        $userBankAccount = Account::where('number', $number)->first();
        $userBankAccount->label = $request->get('label');
        $userBankAccount->save();
        return redirect()->back();
    }
*/
/*
    public function showAccounts(): View
    {
        $userBankAccounts = Account::where('user_id', auth()->id())->get();
        return view('accounts.show', ['userBankAccounts' => $userBankAccounts]);
    }
*/
    public function showDepositWithdrawForm(): View
    {
        $userBankAccounts = $this->bankAccountOperationService->getUserBankAccounts();
        //dd($userBankAccounts->getAll());
        return view('deposit-withdraw', ['userBankAccounts' => $userBankAccounts]);
    }

    public function showDashboard(): View
    {

       // $repository = new CoinMarketCapCryptoRepository();
       // $crypto = $repository->getBySymbol('BTC');
        //var_dump($crypto);

        //$crypto = (new CoinMarketCapCryptoRepository())->getCryptoDetails("BTC,ETH,XRP,DOGE,ADA,LTC,BNB,USDT,USDC,SOL");
        //var_dump($crypto);

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();
        //dd($userBankAccounts->getAll());
        return view('dashboard', ['userBankAccounts' => $userBankAccounts
        , 'codes' => $codes]);
    }

    public function showAccount(string $id): View
    {
        $user = auth()->user();
        //get all account-transactions from ebanking database
          $allTransactions = Transaction::all();
        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();


        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();


        $cryptoPortfolio = CryptoPortfolio::where('bank_account_id', $userBankAccount->id)->get();
        if(count($cryptoPortfolio) > 0)
        {
            $cryptoPortfolioSymbols = $cryptoPortfolio->map(function ($item) {
                return $item->symbol;
            })->toArray();

            $cryptoCurrentInformation = $this->cryptoService->getCryptoList(implode("," ,$cryptoPortfolioSymbols), $userBankAccount->currency);
            $cryptoCurrentPrice = $cryptoCurrentInformation->map(function ($item) {
                return $item->getPrice();
            })->toArray();

        }

        $allTransactions = Transaction::where('recipient_account', $userBankAccount->number)->orWhere('sender_account', $userBankAccount->number)->latest()->get();;

        $transactions = $allTransactions->where('user_id', auth()->id());

        $currentMonthTransactions = $transactions->filter(function ($transaction) {
            return $transaction->created_at->month == now()->month;
        });

        $credit = $currentMonthTransactions->where('type', 'Incoming Payment')->sum('received_amount');
        $debit = $currentMonthTransactions->where('type', 'Outgoing Payment')->sum('sent_amount');

        $currentMonthStart = new DateTime('first day of this month');
        $currentMonthEnd = new DateTime('last day of this month');

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        //get total crypto portfolio value
        $cryptoPortfolioValue = 0;
        foreach ($cryptoPortfolio as $crypto) {
            $cryptoPortfolioValue += $crypto->total;
        }

        //get total profit/loss
        $totalProfitLoss = 0;
        foreach ($cryptoPortfolio as $key => $crypto) {
            $totalProfitLoss -= (($crypto->avg_price - $cryptoCurrentPrice[$key]) * $crypto->amount);
        }

        if(!$userBankAccount = Account::where('id', $id)
            ->where('user_id', auth()->id())
            ->first())
        {
            abort(404);
        }
        return view('accounts.show', [
            'user' => $user,
            'userBankAccount' => $userBankAccount,
            'currentMonthTransactions' => $currentMonthTransactions,
            'codes' => $codes,
            'codeIndex' => $codeIndex,
            'debit' => $debit,
            'credit' => $credit,
            'currentMonthStart' => $currentMonthStart,
            'currentMonthEnd' => $currentMonthEnd,
            'cryptoPortfolio' => $cryptoPortfolio ?? null,
            'cryptoCurrentPrice' => $cryptoCurrentPrice ?? null,
            'cryptoPortfolioValue' => $cryptoPortfolioValue ?? null,
            'totalProfitLoss' => $totalProfitLoss ?? null,
        ]);
    }

    public function updateLabel(Request $request, $id): RedirectResponse
    {
        $userBankAccount = Account::find($id);  // use the ID to fetch the account
        $userBankAccount->label = $request->get('label');
        $userBankAccount->save();
        return redirect()->back();
    }

    public function showTransferForm(): View
    {
        //$codeCard = CodeCard::where('user_id', auth()->id())->first();
        //$codes = json_decode($codeCard->codes);
       // $codeIndex = rand(0, count($codes) - 1);
        //dd($codeIndex);


       // $codeCard = CodeCard::where('user_id', auth()->id())->first();
       // $codes = json_decode($codeCard->codes);
       // $codes = array_combine(range(1, count($codes)), $codes);
      //  $codeIndex = rand(1, count($codes));
       // dd($codes, $codeIndex);

        // Retrieve the user's bank accounts
        $userBankAccounts = Account::where('user_id', auth()->id())->get();
/*
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codeIndex = rand(0, count($codes) - 1);
*/
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));


        ///$repository = new CurrencyApiRepository();

        // $exchangeFrom = (new CurrencyApiRepository())->getExchangeRate($toCurrency);
        //  $exchangeTo = (new CurrencyApiRepository())->getExchangeRate($fromCurrency);

      //  $exchangeFrom = Cache::remember('exchangeRate', 500, function () use ($repository) {
      //      return $repository->getExchangeRates();
    //    });

        $exchangeRates = (new CurrencyApiRepository())->getExchangeRates();

        return view('accounts.transfer', [
            'userBankAccounts' => $userBankAccounts,
            'codes' => $codes,
            'codeIndex' => $codeIndex,
            'exchangeRates' => $exchangeRates
        ]);
    }

    public function transfer(Request $request): RedirectResponse
    {
/*
        $fromCurrency = Account::where('number', $request->get('from_account'))->value('currency');
        $toCurrency = Account::where('number', $request->get('to_account'))->value('currency');

        $amount = $request->get('amount');

        $exchangeFrom = (new CurrencyApiRepository())->getExchangeRate($toCurrency);
        $exchangeTo = (new CurrencyApiRepository())->getExchangeRate($fromCurrency);
        $amount = $amount * $exchangeFrom / $exchangeTo;
        $amount = round($amount, 2);

        dd($fromCurrency, $toCurrency, $amount, $exchangeFrom, $exchangeTo);
*/


        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));
        //dd($codeIndex);
        $request->validate([
            //'from_account' => ['required', new OwnAccountRule()],
           // 'from_account' => ['required', Rule::in($userBankAccounts)],

            //from_account exists in user's bank accounts
            'from_account' => ['required', Rule::exists('accounts', 'number')->where(function ($query) {
                $query->where('user_id', auth()->id());
            })],
            'to_account' => 'required|exists:accounts,number|different:from_account',  // check if to_account exists in the accounts table
            'amount' => 'required|numeric|min:0.01|max:' . Account::where('number', $request->get('from_account'))->value('balance'),
            'password' => 'required|current_password',
            'details' => 'required',
            'code' => ['required', new CodeMatchRule($codes)],
        ]);


/*
        //covert to chosen currency
        $exchangeRates = (new CurrencyApiRepository())->getExchangeRates();
        $amount = $request->input('amount');
        $fromCurrency = $request->input('from_currency');
        $toCurrency = $request->input('to_currency');
        $amount = $amount * $exchangeRates[$fromCurrency] / $exchangeRates[$toCurrency];
        $amount = round($amount, 2);
        //dd($amount);
*/

        //compare to_account and from_account currencies and if different convert transfer an=mount to to_account currency
//$fromAccount = Account::where('number', $request->get('from_account'))->first();
//$toAccount = Account::where('number', $request->get('to_account'))->first();
//$fromCurrency = $fromAccount->currency;
//$toCurrency = $toAccount->currency;

/*

        $fromCurrency = Account::where('number', $request->get('from_account'))->value('currency')->first();
        $toCurrency = Account::where('number', $request->get('to_account'))->value('currency')->first();

$amount = $request->get('amount');
if ($fromCurrency !== $toCurrency) {
    $exchangeRates = (new CurrencyApiRepository())->getExchangeRates();
    $amount = $amount * $exchangeRates[$fromCurrency] / $exchangeRates[$toCurrency];
    $amount = round($amount, 2);
}
//dd($amount);

*//*
        $fromCurrency = Account::where('number', $request->get('from_account'))->value('currency');
        $toCurrency = Account::where('number', $request->get('to_account'))->value('currency');

        var_dump($fromCurrency, $toCurrency);

        $amount = $request->get('amount');
        if ($fromCurrency !== $toCurrency) {
            $exchangeRates = (new CurrencyApiRepository())->getExchangeRates();
            $amount = $amount * $exchangeRates[$fromCurrency] / $exchangeRates[$toCurrency];
            $amount = round($amount, 2);
        }
*/

        try {
            DB::transaction(function () use ($request) {

                $fromCurrency = Account::where('number', $request->get('from_account'))->value('currency');
                $toCurrency = Account::where('number', $request->get('to_account'))->value('currency');

                /*
                //use cache to store exchange rates
                $exchangeRates = Cache::remember('exchange_rates', 3600, function () {
                    return (new CurrencyApiRepository())->getExchangeRates();
                });
*/


                //get exchange rates from cache
                //$exchangeRates = Cache::get('exchangeRate');

     //         $repository = new CurrencyApiRepository();

                $exchangeFrom = (new CurrencyApiRepository())->getExchangeRate($toCurrency);
                $exchangeTo = (new CurrencyApiRepository())->getExchangeRate($fromCurrency);

    //            $exchangeFrom = Cache::remember('exchangeRate' . $toCurrency, 500, function () use ($repository, $toCurrency) {
     //               return $repository->getExchangeRate($toCurrency);
       //         });

      //          $exchangeTo = Cache::remember('exchangeRate' . $fromCurrency, 500, function () use ($repository, $fromCurrency) {
       //             return $repository->getExchangeRate($fromCurrency);
       //         });



                $amount = $request->get('amount') * $exchangeFrom / $exchangeTo;

                Account::where('number', $request->get('from_account'))->decrement('balance', $request->get('amount'));
                Account::where('number', $request->get('to_account'))->increment('balance', $amount);

                Transaction::create([
                    'user_id' => auth()->id(),
                    'received_currency' => Account::where('number', $request->get('from_account'))->value('currency'),
                    'sent_currency' => Account::where('number', $request->get('to_account'))->value('currency'),
                    'conversion_rate' => $exchangeFrom / $exchangeTo,
                    'received_amount' => $amount,
                    'sent_amount' => -$request->get('amount'),
                    'recipient_account' => $request->get('to_account'),
                    'sender_account' => $request->get('from_account'),
                    'sender_name' => auth()->user()->name,
                    'sender_surname' => auth()->user()->surname,
                    'recipient_name' =>  User::all()->where('id', Account::where('number', $request->get('to_account'))->value('user_id'))->first()->name,
                    'recipient_surname' =>  User::all()->where('id', Account::where('number', $request->get('to_account'))->value('user_id'))->first()->surname,
                    'details' => $request->get('details'),
                    'type' => 'Outgoing Payment',
                ]);

                Transaction::create([
                    'user_id' => Account::where('number', $request->get('to_account'))->value('user_id'),
                    'received_currency' => Account::where('number', $request->get('from_account'))->value('currency'),
                    'sent_currency' => Account::where('number', $request->get('to_account'))->value('currency'),
                    'conversion_rate' => $exchangeFrom / $exchangeTo,
                    'received_amount' => $amount,
                    'sent_amount' => -$request->get('amount'),
                    'recipient_account' => $request->get('to_account'),
                    'sender_account' => $request->get('from_account'),
                    'sender_name' => auth()->user()->name,
                    'sender_surname' => auth()->user()->surname,
                    'recipient_name' =>  User::all()->where('id', Account::where('number', $request->get('to_account'))->value('user_id'))->first()->name,
                    'recipient_surname' =>  User::all()->where('id', Account::where('number', $request->get('to_account'))->value('user_id'))->first()->surname,
                    'details' => $request->get('details'),
                    'type' => 'Incoming Payment',
                ]);






                //dd($fromCurrency, $toCurrency, $amount, $exchangeFrom, $exchangeTo);

                // USD , EUR, 0,94, 1.05, 1.06638
            });
        } catch (\Exception $e) {
            // handle exception
        }

        //insert into account-transactions table

        /*
        Transaction::create([
            'currency' => Account::where('number', $request->get('to_account'))->value('currency'),
            'type' => 'Outgoing Payment',
            'sender_account_number' => $request->get('from_account'),
            'recipient_account_number' => $request->get('to_account'),
            'amount' => $request->get('amount'),
            'conversion_rate' => $exchangeFrom / $exchangeTo,
            'user_id' => auth()->id(),
            'sender_name' => auth()->user()->name,
            'sender_surname' => auth()->user()->surname,
            'recipient_name' => User::all()->where('id', Account::where('number', $request->get('to_account'))->value('user_id'))->first()->name,
            'recipient_surname' => User::all()->where('id', Account::where('number', $request->get('to_account'))->value('user_id'))->first()->surname,
            'details' => $request->get('details'),
        ]);
*/
        //redirect back with success message
        //return redirect()->back()->with('success', 'Transfer successful');

        return redirect()->back()->with('success', 'Payment successful');
    }

    public function showSenderBalance(Request $request): JsonResponse
    {
        //$accountNumber = $request->input('from_account'); //accountNumber
       // $account = Account::where('number', $request->get('from_account'))->first();
        //return response()->json(['balance' => $account->balance]);
        $balance = Account::where('number', $request->get('from_account'))->value('balance');
        return response()->json(['balance' => $balance]);
    }

    public function showRecipientCurrency(Request $request): JsonResponse
    {
        $currency = DB::table('accounts')->where('number', $request->account)->value('currency');
         return response()->json(['currency' => $currency]);

       // $currency = DB::table('accounts')->where('number', $request->input('account'))->value('currency');
     //   return response()->json(['currency' => $currency]);
    }




    /*
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'account' => ['required', 'string', 'size:18'],
            'password' => ['required', 'string', 'min:8'],
            //validate password to match session user password
            'code' => ['required', 'string', 'size:6'],

            //'currency' => ['required', 'string', 'size:3'],
        ]);

        $this->bankAccountOperationService->deposit($request->account, $request->amount);

        return redirect()->route('/dashboard');
    }
*/
}
