<?php

namespace App\Models\Collections;

use App\Models\Crypto;

class CryptoCollection
{
private array $currencies = [];

  public function __construct(array $currencies = [])
  {
    foreach ($currencies as $currency) {
      $this->add($currency);
    }
  }

  public function add(Crypto $crypto): void
  {
    $this->currencies[] = $crypto;
  }

  public function getAll(): array
  {
    return $this->currencies;
  }
}
