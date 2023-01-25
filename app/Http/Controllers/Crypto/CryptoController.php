<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\Crypto\CryptoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CryptoController extends Controller
{
    private CryptoService $cryptoCurrencyService;
    const CURRENCIES = [
        'USD', 'EUR', 'JPY', 'GBP', 'CHF',
        'AUD', 'CAD', 'HKD', 'SGD', 'KRW',
        'CNY', 'INR', 'TWD', 'THB', 'BRL',
        'MXN', 'RUB', 'ZAR', 'SEK', 'IDR'
    ];
    const CRYPTO = "BTC,ETH,XRP,DOGE,ADA,LTC,BNB,USDT,USDC,SOL";

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

        if ($request->get('currency') !== null) {
            $ascendingCryptoTop = $this->cryptoCurrencyService->getAscendingTop($request->get('currency'));
            $descendingCryptoTop = $this->cryptoCurrencyService->getDescendingTop($request->get('currency'));
            $cryptoCurrencies = $this->cryptoCurrencyService->getCryptoList(self::CRYPTO, $request->get('currency'));
            return view('crypto.index', [
                'cryptoCurrencies' => $cryptoCurrencies,
                'currencies' => self::CURRENCIES,
                'ascendingCryptoTop' => $ascendingCryptoTop,
                'descendingCryptoTop' => $descendingCryptoTop,
            ]);
        }

        $ascendingCryptoTop = $this->cryptoCurrencyService->getAscendingTop();
        $descendingCryptoTop = $this->cryptoCurrencyService->getDescendingTop();

        $cryptoCurrencies = $this->cryptoCurrencyService->getCryptoList(self::CRYPTO);

        return view('crypto.index', [
            'cryptoCurrencies' => $cryptoCurrencies,
            'currencies' => self::CURRENCIES,
            'ascendingCryptoTop' => $ascendingCryptoTop,
            'descendingCryptoTop' => $descendingCryptoTop,
        ]);
    }

    public function show(Request $request): View
    {
        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $query = strtoupper($request->input('query'));

        $crypto = $this->cryptoCurrencyService->getSingleCrypto($query);

        $metadata = $this->cryptoCurrencyService->getCryptoMetadata($query)->toArray();

        return view('crypto.show', [
            'userBankAccounts' => $userBankAccounts,
            'currencies' => self::CURRENCIES,
            'crypto' => $crypto,
            'metadata' => $metadata,
        ]);
    }

    public function showByCurrency(Request $request, string $symbol): View
    {
        $metadata = $this->cryptoCurrencyService->getCryptoMetadata($symbol);

        $crypto = $this->cryptoCurrencyService->getSingleCrypto($symbol, $request->get('currency'));

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        return view('crypto.show', [
            'userBankAccounts' => $userBankAccounts,
            'crypto' => $crypto,
            'currencies' => self::CURRENCIES,
            'metadata' => $metadata->toArray(),
        ]);
    }
}
