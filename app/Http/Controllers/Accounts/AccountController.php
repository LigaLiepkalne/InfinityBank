<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\CryptoPortfolio;
use App\Models\Transaction;
use App\Services\Crypto\CryptoPortfolioService;
use App\Services\CurrencyExchangeRate\CurrencyApiService;
use DateTime;
use Illuminate\View\View;

class AccountController extends Controller
{
    private CryptoPortfolioService $cryptoPortfolioService;
    private CurrencyApiService $currencyApiService;

    public function __construct(CryptoPortfolioService $cryptoPortfolioService, CurrencyApiService $currencyApiService)
    {
        $this->cryptoPortfolioService = $cryptoPortfolioService;
        $this->currencyApiService = $currencyApiService;
    }

    public function index(): View
    {
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $totalBalance8 = 0;
        foreach ($userBankAccounts as $account) {
            $totalBalance8 += $account->balance;
        }

        //get user account count
        $userAccountCount = Account::where('user_id', auth()->id())->count();

        //get diffferent user account currency count
        $userAccountCurrencyCount = Account::where('user_id', auth()->id())->distinct('currency')->count('currency');


        //get $userBankAccounts crypto_portfolios_by_bank_account
        //$userBankAccountsCryptoPortfolios = [];
        $userCryptoPortfoliosCount = CryptoPortfolio::whereIn('bank_account_id', $userBankAccounts->pluck('id'))->distinct()->get(['bank_account_id']);
        $userCryptoPortfoliosCount = $userCryptoPortfoliosCount->count();

/*
        $totalBalance = 0;
        foreach ($userBankAccounts as $account) {
            $totalBalance += $account->balance * $this->currencyApiService->getExchangeRate($account->currency);
        }
*/

        return view('dashboard', [
            'userBankAccounts' => $userBankAccounts,
            'codes' => $codes,
            'totalBalance8' => $totalBalance8,
            'userAccountCount' => $userAccountCount,
            'userAccountCurrencyCount' => $userAccountCurrencyCount,
            'userCryptoPortfoliosCount' => $userCryptoPortfoliosCount,
        ]);
    }

    public function show(string $id): View
    {
        $user = auth()->user();

        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();

        $cryptoPortfolio = $this->cryptoPortfolioService->getPortfolio($id);

        if(count($this->cryptoPortfolioService->getPortfolio($id)) > 0) {
            $cryptoCurrentPrice = $this->cryptoPortfolioService->getPortfolioCryptoCurrentPrice($id);
            $cryptoPortfolioValue = $this->cryptoPortfolioService->getPortfolioValue($id);
            $totalProfitLoss = $this->cryptoPortfolioService->getPortfolioProfitLoss($id);
        }

        $userTransactions = Transaction::where('recipient_account', $userBankAccount->number)
            ->orWhere('sender_account', $userBankAccount->number)
            ->latest()->where('user_id', auth()->id())
            ->get();

        $currentMonthTransactions = $userTransactions->filter(function ($transaction) {
            return $transaction->created_at->month == now()->month;
        });

        $credit = $currentMonthTransactions->where('type', 'Incoming Payment')->where('recipient_account', $userBankAccount->number)->sum('received_amount');
        $debit = $currentMonthTransactions->where('type', 'Outgoing Payment')->where('sender_account', $userBankAccount->number)->sum('sent_amount');

        $currentMonthStart = new DateTime('first day of this month');
        $currentMonthEnd = new DateTime('last day of this month');

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

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
            'cryptoPortfolio' => $cryptoPortfolio,
            'cryptoCurrentPrice' => $cryptoCurrentPrice ?? null,
            'cryptoPortfolioValue' => $cryptoPortfolioValue ?? null,
            'totalProfitLoss' => $totalProfitLoss ?? null,
        ]);
    }
}
