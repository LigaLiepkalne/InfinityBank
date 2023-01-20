<?php

namespace App\Providers;

use App\Composers\CodeCardComposer;
use App\Repositories\Crypto\CoinMarketCapCryptoRepository;
use App\Repositories\Crypto\CryptoRepository;
use App\Repositories\CurrencyApiRepository;
use App\Repositories\CurrencyRepository;
use App\Services\Crypto\BuyCryptoService;
use App\Services\Crypto\CryptoPortfolioService;
use App\Services\Crypto\CryptoService;
use App\Services\Crypto\SellCryptoService;
use App\Services\CurrencyExchangeRate\CurrencyApiService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CryptoRepository::class, CoinMarketCapCryptoRepository::class);
        $this->app->singleton(CryptoService::class, function ($app) {
            return new CryptoService($app->make(CryptoRepository::class));
        });

        $this->app->singleton(CryptoPortfolioService::class, function ($app) {
            return new CryptoPortfolioService($app->make(CryptoRepository::class));
        });

        $this->app->singleton(BuyCryptoService::class, function ($app) {
            return new BuyCryptoService($app->make(CryptoRepository::class));
        });

        $this->app->singleton(SellCryptoService::class, function ($app) {
            return new SellCryptoService($app->make(CryptoRepository::class));
        });

        $this->app->bind(CurrencyRepository::class, CurrencyApiRepository::class);
        $this->app->singleton(CurrencyApiService::class, function ($app) {
            return new CurrencyApiService($app->make(CurrencyRepository::class));
        });
    }

    public function boot()
    {
        View::composer(
            '*', CodeCardComposer::class
        );
    }
}
