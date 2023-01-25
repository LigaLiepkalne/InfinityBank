<?php

namespace App\Repositories\Currency;

use Illuminate\Support\Collection;

interface CurrencyRepository
{
    public function getExchangeRates(): Collection;

    public function getExchangeRate($currency): float;
}
