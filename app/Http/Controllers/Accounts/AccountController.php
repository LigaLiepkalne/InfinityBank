<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Transaction;
use App\Services\Crypto\CryptoPortfolioService;
use DateTime;
use Illuminate\View\View;

class AccountController extends Controller
{
    private CryptoPortfolioService $cryptoPortfolioService;

    public function __construct(CryptoPortfolioService $cryptoPortfolioService)
    {
        $this->cryptoPortfolioService = $cryptoPortfolioService;
    }

    public function index(): View
    {
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        return view('dashboard', ['userBankAccounts' => $userBankAccounts, 'codes' => $codes]);
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

        $credit = $currentMonthTransactions->where('type', 'Incoming Payment')->sum('received_amount');
        $debit = $currentMonthTransactions->where('type', 'Outgoing Payment')->sum('sent_amount');

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
