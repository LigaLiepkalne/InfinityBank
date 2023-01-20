<?php

namespace App\Services\Crypto;

use App\Models\Crypto;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Collection;

class CryptoService
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function getCryptoList(string $search=null, string $currency="EUR"): Collection
    {
        return $this->cryptoRepository->getCrypto($search, $currency);
    }

    public function getCryptoPrice(string $symbol, string $currency="EUR"): float
    {
        return $this->cryptoRepository->getCryptoPrice($symbol, $currency);
    }

    public function getSingleCrypto(string $search, string $currency="EUR"): Crypto
    {
        return $this->cryptoRepository->getBySymbol($search, $currency);
    }

    public function getByVolume(string $search=null, string $currency="EUR"): Collection
    {
        return $this->cryptoRepository->getByVolume($search, $currency);
    }

    public function getAscendingTop(string $currency="EUR"): Collection
    {
        return $this->cryptoRepository->getAscendingTop($currency);
    }

    public function getDescendingTop(string $currency="EUR"): Collection
    {
        return $this->cryptoRepository->getDescendingTop($currency);
    }

    public function getCryptoMetadata(string $symbol): Collection
    {
        return $this->cryptoRepository->getCryptoMetadata($symbol);
    }
}
