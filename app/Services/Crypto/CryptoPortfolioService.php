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

    public function getPortfolioCryptoCurrentPrice(string $id): array
    {
        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();

        $portfolioSymbols = $this->getPortfolio($id)->pluck('symbol')->toArray();
        $currentData = $this->cryptoRepository->getCrypto(
            implode(",", $portfolioSymbols), $userBankAccount->currency)
            ->toArray();

        usort($currentData, function ($a, $b) use ($portfolioSymbols) {
            $aIndex = array_search($a->getSymbol(), $portfolioSymbols);
            $bIndex = array_search($b->getSymbol(), $portfolioSymbols);
            return $aIndex <=> $bIndex;
        });

        $price = [];
        foreach ($currentData as $item) {
            $price[] = $item->getPrice();
        };
        return $price;
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

