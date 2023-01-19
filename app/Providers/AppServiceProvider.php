<?php

namespace App\Providers;

use App\Models\Account;
use App\Repositories\Crypto\CoinMarketCapCryptoRepository;
use App\Repositories\Crypto\CryptoRepository;
use App\Services\AccountOperationsService;
use App\Services\Crypto\BuyCryptoService;
use App\Services\Crypto\CryptoPortfolioService;
use App\Services\Crypto\CryptoService;
use App\Services\Crypto\SellCryptoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        $this->app->singleton(AccountOperationsService::class, function ($app) {
            return new AccountOperationsService(new Account());
        });
*/
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
