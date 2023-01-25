<?php

namespace App\Repositories\Currency;

use App\Models\CurrencyExchangeRate;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CurrencyApiRepository implements CurrencyRepository
{
    public function __construct()
    {
        $this->apiKey = env('CURRENCY_EXCHANGE_RATE_API_KEY');
    }

    public function getExchangeRates(): Collection
    {
        $data = Cache::remember('exchangeRates', 60, function () {
            $client = new Client();
            $response = $client->get('https://api.currencyapi.com/v3/latest', [
                'query' => [
                    'base_currency' => 'EUR',
                    'currencies' => 'USD,EUR,JPY,GBP,CHF,AUD,CAD,HKD,SGD,KRW,CNY,INR,TWD,THB,BRL,MXN,RUB,ZAR,SEK,IDR',
                ],
                'headers' => [
                    'apikey' => $this->apiKey
                ],
            ]);
            $responseBody = $response->getBody();

            return json_decode($responseBody, true);
        });

        $exchangeRates = collect();
        Carbon::parse($data['meta']['last_updated_at']);

        foreach ($data['data'] as $currency => $rate) {
            $exchangeRates->push(new CurrencyExchangeRate($currency, $rate['value'], $data['meta']['last_updated_at']));
        }
        return $exchangeRates;
    }

    public function getExchangeRate($currency): float
    {
        return Cache::remember('exchangeRate' . $currency, 60, function () use ($currency) {
            $client = new Client();
            $response = $client->get('https://api.currencyapi.com/v3/latest', [
                'query' => [
                    'base_currency' => 'EUR',
                    'currencies' => $currency,
                ],
                'headers' => [
                    'apikey' => $this->apiKey
                ],
            ]);
            $responseBody = $response->getBody();

            $data = json_decode($responseBody, true);
            return $data['data'][$currency]['value'];
        });
    }
}
