<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Models\CurrencyExchangeRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;


class CurrencyApiRepository
{
    public function __construct()
    {
        $this->apiKey = env('CURRENCY_EXCHANGE_RATE_API_KEY');
    }
/*
    public function getExchangeRates(): Collection
    {
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

        $data = json_decode($responseBody, true);

        $exchangeRates = collect();
        Carbon::parse($data['meta']['last_updated_at']);

        foreach ($data['data'] as $currency => $rate) {
            $exchangeRates->push(new CurrencyExchangeRate($currency, $rate['value'], $data['meta']['last_updated_at']));
        }
        return $exchangeRates;
    }
*/

    public function getExchangeRates(): Collection
    {
        // Try to get the data from cache
        $data = Cache::get('exchangeRates');
        // If the data isn't in cache, fetch it from the API
        if (!$data) {
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

            $data = json_decode($responseBody, true);
            // Store the data in cache for 1 hour
            Cache::put('exchangeRates', $data, 100);
           // Cache::put($search, $response, now()->addMinutes(60));

        }

        $exchangeRates = collect();
        Carbon::parse($data['meta']['last_updated_at']);

        foreach ($data['data'] as $currency => $rate) {
            $exchangeRates->push(new CurrencyExchangeRate($currency, $rate['value'], $data['meta']['last_updated_at'])
            );
        }
        return $exchangeRates;
    }

    public function getExchangeRate($currency): float
    {
        // Try to get the data from cache
        $data = Cache::get('exchangeRate' . $currency);
        // If the data isn't in cache, fetch it from the API
        if (!$data) {
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
            // Store the data in cache for 1 hour
            Cache::put('exchangeRate' . $currency, $data, 100);
        }
        return $data['data'][$currency]['value'];
    }





/*
    public function getExchangeRate($currency): float
    {
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
/*
        //return data using cache
        Cache::remember('exchangeRate' . $currency, 3600, function () use ($data)
        {
            return $data;
        });

        return $data['data'][$currency]['value'];
    }

*/

}
