<?php

namespace App\Models;

class CurrencyExchangeRate {
    private string $symbol;
    private string $rate;
    private string $date;

    public function __construct(string $symbol, string $rate, string $date) {
        $this->symbol = $symbol;
        $this->rate = $rate;
        $this->date = $date;
    }

    public function getSymbol(): string {
        return $this->symbol;
    }

    public function getRate(): string {
        return $this->rate;
    }

    public function getDate(): string {
        return $this->date;
    }
}
