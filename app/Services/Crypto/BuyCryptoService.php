<?php

namespace App\Services\Crypto;

use App\Models\Account;
use App\Models\CryptoPortfolio;
use App\Models\CryptoTransaction;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Facades\DB;

class BuyCryptoService
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function execute(TradeCryptoServiceRequest $request): void
    {
        $accountCurrency = Account::where('id', $request->getUserAccountId())->value('currency');
        $crypto = $this->cryptoRepository->getBySymbol($request->getSymbol(), $accountCurrency);
        $price = $crypto->getPrice();

        $accountId = Account::where('id', $request->getUserAccountId())->first()->id;
        $ownsCrypto = CryptoPortfolio::where('bank_account_id', $accountId)
            ->where('symbol', $request->getSymbol())
            ->exists();

        Account::find($request->getUserAccountId())->decrement('balance', $price * $request->getAmount());

        CryptoTransaction::create([
            'bank_account_id' => $accountId,
            'symbol' => $request->getSymbol(),
            'price' => $price,
            'amount' => $request->getAmount(),
            'total' => $price * $request->getAmount(),
            'type' => 'Buy'
        ]);

        if ($ownsCrypto) {
            CryptoPortfolio::where('bank_account_id', $accountId)
                ->where('symbol', $request->getSymbol())
                ->update([
                    'amount' => DB::raw('amount + '.$request->getAmount()),
                    'purchase_count' => DB::raw('purchase_count + 1'),
                    'price_sum' => DB::raw('price_sum + '. $price ),
                    'price' => $price,
                    'avg_price' => DB::raw('price_sum / purchase_count'),
                    'total' => DB::raw('amount * price')
                ]);
        } else {
            CryptoPortfolio::create([
                'bank_account_id' => $accountId,
                'symbol' => $request->getSymbol(),
                'price' => $price,
                'amount' => $request->getAmount(),
                'total' => $price * $request->getAmount(),
                'purchase_count' => 1,
                'price_sum' => $price,
                'avg_price' => $price
            ]);
        }
    }
}
