<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Repositories\Crypto\CoinMarketCapCryptoRepository;
use App\Services\Crypto\CryptoService;
use CoinMarketCap\Features\Cryptocurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CryptoController extends Controller
{

    private CryptoService $cryptoCurrencyService;

    public function __construct(CryptoService $cryptoCurrencyService)
    {
        $this->cryptoCurrencyService = $cryptoCurrencyService;
    }

    public function index(Request $request): View
    {
        if (request()->get('search') !== null) {
            $crypto = $this->cryptoCurrencyService->getSingleCrypto(request()->get('search'));
            return view('show.blade', [
                'cryptos' => $crypto,
            ]);
        }

        $currencies = [
            'USD', 'EUR', 'JPY', 'GBP', 'CHF',
            'AUD', 'CAD', 'HKD', 'SGD', 'KRW',
            'CNY', 'INR', 'TWD', 'THB', 'BRL',
            'MXN', 'RUB', 'ZAR', 'SEK', 'IDR'
        ];

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        if($request->get('currency') !== null){
            $currency = $request->get('currency');
            $cryptoCurrencies = $this->cryptoCurrencyService->getCryptoList("BTC,ETH,XRP,DOGE,ADA,LTC,BNB,USDT,USDC,SOL", $currency);
            return view('crypto.index', [
                'cryptoCurrencies' => $cryptoCurrencies,
                'currencies' => $currencies,
                // 'cryptoByVolume' => $cryptoByVolume,
                'codes' => $codes,
            ]);
        }
        Cache::flush();
        $cryptoCurrencies = $this->cryptoCurrencyService->getCryptoList("BTC,ETH,XRP,DOGE,ADA,LTC,BNB,USDT,USDC,SOL");

        return view('crypto.index', [
            'cryptoCurrencies' => $cryptoCurrencies,
            'currencies' => $currencies,
           // 'cryptoByVolume' => $cryptoByVolume,
            'codes' => $codes,
        ]);
    }
/*
    public function show(string $symbol): View
    {
        $crypto = $this->cryptoCurrencyService->getSingleCrypto($symbol);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        return view('show.blade', [
            'crypto' => $crypto,
            'userBankAccounts' => $userBankAccounts,
            'codeIndex' => $codeIndex,
            'codes' => $codes,
        ]);
    }
*/
    public function show(Request $request): View
    {

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));
        $currencies = ['USD', 'EUR', 'JPY', 'GBP', 'CHF', 'AUD', 'CAD', 'HKD', 'SGD', 'KRW', 'CNY', 'INR', 'TWD', 'THB', 'BRL', 'MXN', 'RUB', 'ZAR', 'SEK', 'IDR'];

            $query = strtoupper($request->input('query'));

            $crypto = $this->cryptoCurrencyService->getSingleCrypto($query);

        $metadata = $this->cryptoCurrencyService->getCryptoMetadata($query);
        Cache::flush();
        return view('crypto.show', [
            'crypto' => $crypto,
            'userBankAccounts' => $userBankAccounts,
            'codeIndex' => $codeIndex,
            'codes' => $codes,
            'currencies' => $currencies ,
            'metadata' => $metadata,
        ]);
    }

    public function showByCurrency(Request $request, string $symbol): View
    {

        $metadata = $this->cryptoCurrencyService->getCryptoMetadata($symbol);


        $currencies = ['USD', 'EUR', 'JPY', 'GBP', 'CHF', 'AUD', 'CAD', 'HKD', 'SGD', 'KRW', 'CNY', 'INR', 'TWD', 'THB', 'BRL', 'MXN', 'RUB', 'ZAR', 'SEK', 'IDR'];
        $currency = $request->get('currency');
        $crypto = $this->cryptoCurrencyService->getSingleCrypto($symbol, $currency);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        return view('crypto.show', [
            'userBankAccounts' => $userBankAccounts,
            'codeIndex' => $codeIndex,
            'codes' => $codes,
            'crypto' => $crypto,
            'currencies' => $currencies,
            'metadata' => $metadata,
        ]);
        //return view('crypto.show', ['crypto' => $crypto]);
    }

    //show single crypto from cryptoAPI

}
