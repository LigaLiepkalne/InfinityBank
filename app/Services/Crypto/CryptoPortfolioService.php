<?php

namespace App\Services\Crypto;

use App\Models\Account;
use App\Models\CryptoPortfolio;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Collection;

class CryptoPortfolioService
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function getPortfolio(string $id): Collection
    {
        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();
        return CryptoPortfolio::where('bank_account_id', $userBankAccount->id)->get();
    }

    public function getPortfolioCurrentData(string $id): Collection
    {
        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();

        $cryptoPortfolioSymbols = $this->getPortfolio($id)->map(function ($item) {
            return $item->symbol;
        })->toArray();

        return $this->cryptoRepository->getCrypto(implode(",", $cryptoPortfolioSymbols), $userBankAccount->currency);
    }

    public function getPortfolioCryptoCurrentPrice(string $id): array
    {
        return $this->getPortfolioCurrentData($id)->map(function ($item) {
                return $item->getPrice();
            })->toArray();
    }

    public function getPortfolioValue(string $id): float
    {
        $cryptoPortfolio = $this->getPortfolio($id);
        $cryptoCurrentPrice = $this->getPortfolioCryptoCurrentPrice($id);

        $cryptoPortfolioValue = 0;

        foreach ($cryptoPortfolio as $key => $crypto) {
            $cryptoPortfolioValue += $crypto->amount * $cryptoCurrentPrice[$key];
        }

        return $cryptoPortfolioValue;
    }

    public function getPortfolioProfitLoss(string $id): float
    {
        $cryptoPortfolio = $this->getPortfolio($id);
        $cryptoCurrentPrice = $this->getPortfolioCryptoCurrentPrice($id);

        $cryptoPortfolioProfitLoss = 0;

        foreach ($cryptoPortfolio as $key => $crypto) {
            $cryptoPortfolioProfitLoss -= (($crypto->avg_price - $cryptoCurrentPrice[$key]) * $crypto->amount);
        }

        return $cryptoPortfolioProfitLoss;
    }
}

