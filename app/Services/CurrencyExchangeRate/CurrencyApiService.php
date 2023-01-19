<?php

namespace App\Services\CurrencyExchangeRate;

use App\Repositories\CurrencyApiRepository;
use Illuminate\Support\Collection;

class CurrencyApiService
{
    private CurrencyApiRepository $currencyApiRepository;

    public function __construct(CurrencyApiRepository $currencyApiRepository)
    {
            $this->currencyApiRepository = $currencyApiRepository;
    }

    public function getExchangeRates(): Collection
    {
        return $this->currencyApiRepository->getExchangeRates();
    }

    public function getExchangeRate(string $currency): float
    {
        return $this->currencyApiRepository->getExchangeRate($currency);
    }
}
