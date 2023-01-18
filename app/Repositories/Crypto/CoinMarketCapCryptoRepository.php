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
        $cryptoCollection = new Collection();
        $response = Cache::remember('crypto_listings_latest_' . $search . $currency, now()->addMinutes(60), function () use ($search, $currency) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $search, 'convert' => $currency])->json();
        });

        usort($response['data'], function ($a, $b) use ($currency) {
            return $a['quote'][$currency]['market_cap'] < $b['quote'][$currency]['market_cap'];
        });

        $info = Cache::remember('crypto_info_' . $search, now()->addMinutes(60), function () use ($search) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $search])->json();
        });

        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
            $cryptoCollection->add($this->buildModel($crypto, $currency));
        }

        return $cryptoCollection;
    }

    public function getBySymbol(string $symbol, string $currency="EUR"): Crypto
    {
        $crypto = Cache::remember('crypto_quotes_latest_' . $symbol . $currency, now()->addMinutes(60), function () use ($symbol, $currency) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $symbol, 'convert' => $currency])->json();
        });

        $info = Cache::remember('crypto_info_' . $symbol, now()->addMinutes(60), function () use ($symbol) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $symbol])->json();
        });

        $crypto = $crypto['data'][$symbol];
        $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
        return $this->buildModel($crypto, $currency);
    }

    public function getCryptoPrice(string $symbol, string $currency="EUR"): float
    {
        $crypto = Cache::remember('crypto_quotes_latest_' . $symbol . $currency, now()->addMinutes(60), function () use ($symbol, $currency) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $symbol, 'convert' => $currency])->json();
        });

        $crypto = $crypto['data'][$symbol];
        return $crypto['quote'][$currency]['price'];
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

    public function getCurrencySymbol(string $currency): string
    {
        $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
        $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currency);
        return $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }

    /*
    public function getByVolume(string $symbol, string $currency): Collection
    {
        $cryptoCollection = new Collection();

        $response = Cache::remember('30DayVolume'. $currency, now()->addMinutes(60), function () use  ($currency) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest", ['convert' => $currency,
                'limit' => 3, 'sort' => 'volume_30d'])->json();
        });

        $info = Cache::remember('crypto_info_' . $symbol, now()->addMinutes(60), function () use ($symbol) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $symbol])->json();
        });

        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']]['logo'];
            $cryptoCollection->add($this->buildModel($crypto, $currency));
        }

        return $cryptoCollection;
    }
*/

    public function getAscendingList(string $currency)
    {
        $cryptoCollection = new Collection();

        $response = Cache::remember('fdfrif7p'.  $currency, now()->addMinutes(60), function () use  ($currency)  {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest", [
                'convert' => $currency,
                'limit' => 3, 'sort_dir' => 'asc',
                'cryptocurrency_type' => 'coins'])->json();
        });

        return $response;


    }
/*
    public function getCrypto(string $search): Collection
    {
        $cryptoCollection = new Collection();
        $response = Cache::remember('crypto_quotes_latest_' . $search . 'convert', now()->addMinutes(60), function () use ($search) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $search, 'convert' => 'EUR'])->json();
        });

        $info = Cache::remember('crypto_info_' . $search, now()->addMinutes(60), function () use ($search) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $search])->json();
        });

        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']];
            $cryptoCollection->add($this->buildModel($crypto));
        }

        return $cryptoCollection;
    }
*/
/*
        public function getCrypto(string $search): Collection
        {
            $cryptoCollection = new Collection();
            $response = Cache::remember('crypto_quotes_latest_' . $search, now()->addMinutes(60), function () use ($search) {
                return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $search])->json();
            });

            $info = Cache::remember('crypto_info_' . $search, now()->addMinutes(60), function () use ($search) {
                return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $search])->json();
            });

            foreach ($response['data'] as $crypto) {
                $crypto['logo'] = $info['data'][$crypto['symbol']];
                $cryptoCollection->add($this->buildModel($crypto));
            }

            return $cryptoCollection;
        }
*/


/*
    public function getBySymbol(string $symbol): Crypto
    {
        $crypto = Cache::remember('crypto_quotes_latest_' . $symbol, now()->addMinutes(60), function () use ($symbol) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $symbol])->json();
        });

        $info = Cache::remember('crypto_info_' . $symbol, now()->addMinutes(60), function () use ($symbol) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $symbol])->json();
        });

        $crypto = $crypto['data'][$symbol];
        $crypto['logo'] = $info['data'][$crypto['symbol']];
        return $this->buildModel($crypto);
    }
*/
/*
        private function buildModel(array $data): Crypto
        {
            return new Crypto(
                $data['id'],
                $data['name'],
                $data['symbol'],
                $data['date_added'],
                $data['last_updated'],
                $data['quote']['EUR']['price'],
                $data['quote']['EUR']['volume_24h'],
                $data['quote']['EUR']['percent_change_1h'],
                $data['quote']['EUR']['percent_change_24h'],
                $data['quote']['EUR']['percent_change_7d'],
                $data['quote']['EUR']['market_cap'],
                $data['logo']['logo'],
            );
        }
*/
    /*
    public function getCrypto(string $search): Collection
    {
        $cryptoCollection = new Collection();
        $response = Cache::remember('crypto_quotes_latest_' . $search, now()->addMinutes(60), function () use ($search) {
            ($this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $search])->json());
        });

        $info = Cache::remember('crypto_info_' . $search , now()->addMinutes(60), function () use ($search) {
            ($this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $search])->json());
        });

        foreach ($response['data'] as $crypto) {
            $crypto['logo'] = $info['data'][$crypto['symbol']];
            //$crypto['logo'] = $info['data'][$crypto['symbol']] ?? 'default_value';
            //$crypto['logo'] = $info['data']['id']['logo'] ?? 'default_value';
            $cryptoCollection->add($this->buildModel($crypto, 'EUR'));
        }

        return $cryptoCollection;
    }

    //build getBySymbol function with dynamic currency parameter
    public function getBySymbol(string $symbol, string $currency = 'EUR'): Crypto
    {
        $response = Cache::remember('crypto_quotes_latest_' . $symbol, now()->addMinutes(60), function () use ($symbol) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest", ['symbol' => $symbol])->json();
        });

        $info = Cache::remember('crypto_info_' . $symbol, now()->addMinutes(60), function () use ($symbol) {
            return $this->client->get("https://pro-api.coinmarketcap.com/v1/cryptocurrency/info", ['symbol' => $symbol])->json();
        });

        $crypto = $response['data'][$symbol];
        $crypto['logo'] = $info['data'][$crypto['symbol']];

        return $this->buildModel($crypto, $currency);
    }

    //build model function with option to pck currency
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
            $crypto['logo']['logo']
        );
    }

*/

}
