<?php

namespace App\Services\Crypto;

class TradeCryptoServiceRequest
{
    private string $userAccountId;
    private string $symbol;
    private ?float $price;
    private ?float $amount;
    private ?float $total;
    private ?int $purchaseCount;
    private ?float $priceSum;
    private ?float $priceAvg;

    public function __construct(
                                string $userAccountId,
                                string $symbol,
                                ?float $price=null,
                                ?float $amount=null,
                                ?float $total=null,
                                ?int   $purchaseCount=null,
                                ?float $priceSum=null,
                                ?float $priceAvg=null)
    {
        $this->userAccountId = $userAccountId;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
        $this->total = $total;
        $this->purchaseCount = $purchaseCount;
        $this->priceSum = $priceSum;
        $this->priceAvg = $priceAvg;
    }

    public function getUserAccountId(): string
    {
        return $this->userAccountId;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function getPurchaseCount(): ?int
    {
        return $this->purchaseCount;
    }

    public function getPriceSum(): ?float
    {
        return $this->priceSum;
    }

    public function getPriceAvg(): ?float
    {
        return $this->priceAvg;
    }

}
