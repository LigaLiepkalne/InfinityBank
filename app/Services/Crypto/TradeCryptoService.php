<?php

namespace App\Services\Crypto;

use App\Repositories\Crypto\CryptoRepository;

class TradeCryptoService
{

    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    pubclic function buyCrypto(string $symbol, int $amount, string $userId): void
    {
        $crypto = $this->cryptoRepository->getBySymbol($symbol);
        $crypto->buy($amount, $userId);
    }


}
