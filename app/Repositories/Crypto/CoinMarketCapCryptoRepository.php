<?php

namespace App\Repositories\Crypto;

use App\Models\Crypto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use NumberFormatter;

class CoinMarketCapCryptoRepository implements CryptoRepository
{
    protected $client;

    public function __construct()
    {
        $this->client = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => env('COIN_MARKET_CAP_API_KEY'),
        ]);
    }

    public function getCrypto(string $search, string $currency): Collection
    {
        $response = Cache::remember('crypto_listings_latest_' . $search . $currency, now()->addMinutes(60),
            function () use ($search, $currency) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest',
                    ['symbol' => $search, 'convert' => $currency])
                    ->json();
            });

        usort($response['data'], function ($a, $b) use ($currency) {
            return $a['quote'][$currency]['market_cap'] < $b['quote'][$currency]['market_cap'];
        });

        $info = Cache::remember('crypto_info_' . $search, now()->addMinutes(60),
            function () use ($search) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info',
                    ['symbol' => $search])
                    ->json();
            });

        $cryptoCollection = new Collection();
        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
            $cryptoCollection->add($this->buildModel($crypto, $currency));
        }

        return $cryptoCollection;
    }

    public function getBySymbol(string $symbol, string $currency = 'EUR'): Crypto
    {
        $crypto = Cache::remember('crypto_quotes_latest_' . $symbol . $currency, now()->addMinutes(60),
            function () use ($symbol, $currency) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest',
                    ['symbol' => $symbol, 'convert' => $currency]
                )->json();
            });

        $info = Cache::remember(
            'crypto_info_' . $symbol, now()->addMinutes(60),
            function () use ($symbol) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info', ['symbol' => $symbol]
                )->json();
            });

        $crypto = $crypto['data'][$symbol];
        $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
        return $this->buildModel($crypto, $currency);
    }

    public function getCryptoPrice(string $symbol, string $currency = 'EUR'): float
    {
        $crypto = Cache::remember('cryptoLatest' . $symbol . $currency, now()->addMinutes(60),
            function () use ($symbol, $currency) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest',
                    ['symbol' => $symbol, 'convert' => $currency]
                )->json();
            });

        $crypto = $crypto['data'][$symbol];
        return $crypto['quote'][$currency]['price'];

    }

    public function getCryptoMetadata(string $symbol): Collection
    {
        $info = Cache::remember('cryptoInfo' . $symbol, now()->addMinutes(60),
            function () use ($symbol) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info', ['symbol' => $symbol])->json();
            });

        $metadata = new Collection();
        $metadata->add([
            'description' => $info['data'][$symbol]['description'],
            'logo' => $info['data'][$symbol]['logo']
        ]);

        foreach ($info['data'][$symbol]['urls'] as $key => $value) {
            $metadata->add([
                'url' => $value,
                'type' => $key
            ]);
        }

        $metadata = $metadata->flatten(2)->reject(function ($value) {
            return empty($value) || strlen($value) <= 13;
        });
        return $metadata;
    }

    public function getCurrencySymbol(string $currency): string
    {
        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currency);
        return $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }

    //additional crypto highlights for index view
    public function getAscendingTop(string $currency): Collection
    {
        $response = Cache::remember('ascendingList' . $currency, now()->addMinutes(60),
            function () use ($currency) {
                return $this->client->get(
                    "https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest", [
                        'convert' => $currency,
                        'limit' => 3, 'sort_dir' => 'asc']
                )->json();
            });

        $info = Cache::remember('cryptoInfo', now()->addMinutes(60),
            function () use ($response) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info',
                    ['symbol' => implode(',', array_column($response['data'], 'symbol'))]
                )->json();
            });
        Cache::flush();
        $cryptoCollection = new Collection();
        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
            $cryptoCollection->add($this->buildModel($crypto, $currency));
        }
        return $cryptoCollection;
    }


    public function getDescendingTop(string $currency): Collection
    {
        $response = Cache::remember('descendingList' . $currency, now()->addMinutes(60),
            function () use ($currency) {
                return $this->client->get(
                    "https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest", [
                        'convert' => $currency,
                        'limit' => 3, 'sort_dir' => 'desc']
                )->json();
            });
        Cache::flush();
        $info = Cache::remember('cryptoInfo', now()->addMinutes(60),
            function () use ($response) {
                return $this->client->get(
                    'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info',
                    ['symbol' => implode(',', array_column($response['data'], 'symbol'))]
                )->json();
            });

        $cryptoCollection = new Collection();
        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
            $cryptoCollection->add($this->buildModel($crypto, $currency));
        }
        return $cryptoCollection;
    }

    private function buildModel(array $crypto, string $currency): Crypto
    {
        return new Crypto(
            $crypto['id'],
            $crypto['name'],
            $crypto['symbol'],
            $crypto['date_added'],
            $crypto['last_updated'],
            $crypto['quote'][$currency]['price'],
            $crypto['quote'][$currency]['volume_24h'],
            $crypto['quote'][$currency]['percent_change_1h'],
            $crypto['quote'][$currency]['percent_change_24h'],
            $crypto['quote'][$currency]['percent_change_7d'],
            $crypto['quote'][$currency]['market_cap'],
            $this->getCurrencySymbol($currency),
            $crypto['logo'],
        );
    }
}
