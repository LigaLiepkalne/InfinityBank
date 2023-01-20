<?php

namespace App\Repositories\Crypto;
use App\Models\Crypto;
use Illuminate\Support\Collection;

interface CryptoRepository
{
    public function getCrypto(string $search, string $currency): Collection;

    public function getBySymbol(string $symbol, string $currency): Crypto;
}



