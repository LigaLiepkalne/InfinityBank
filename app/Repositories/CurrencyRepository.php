<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface CurrencyRepository
{
    public function getExchangeRates(): Collection;

    public function getExchangeRate($currency): float;
}
