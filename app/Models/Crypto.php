<?php

namespace App\Models;

class Crypto
{
    private string $id;
    private string $name;
    public string $symbol;
    private string $dateAdded;
    private string $lastUpdated;
    private float $price;
    private float $volume24h;
    private float $percentChange1h;
    private float $percentChange24h;
    private float $percentChange7d;
    private float $marketCap;
    private string $currency;
    private ?string $logoURL;

    public function __construct(

        string  $id,
        string  $name,
        string  $symbol,
        string  $dateAdded,
        string  $lastUpdated,
        float   $price,
        float   $volume24h,
        float   $percentChange1h,
        float   $percentChange24h,
        float   $percentChange7d,
        float   $marketCap,
        string  $currency,
        ?string $logoURL = null
    )

    {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->dateAdded = $dateAdded;
        $this->lastUpdated = $lastUpdated;
        $this->price = $price;
        $this->volume24h = $volume24h;
        $this->percentChange1h = $percentChange1h;
        $this->percentChange24h = $percentChange24h;
        $this->percentChange7d = $percentChange7d;
        $this->marketCap = $marketCap;
        $this->currency = $currency;
        $this->logoURL = $logoURL;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    public function getLastUpdated(): string
    {
        return $this->lastUpdated;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVolume24h(): float
    {
        return $this->volume24h;
    }

    public function getPercentChange1h(): float
    {
        return $this->percentChange1h;
    }

    public function getPercentChange24h(): float
    {
        return $this->percentChange24h;
    }

    public function getPercentChange7d(): float
    {
        return $this->percentChange7d;
    }

    public function getMarketCap(): float
    {
        return $this->marketCap;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getLogoURL(): ?string
    {
        return $this->logoURL;
    }
}
