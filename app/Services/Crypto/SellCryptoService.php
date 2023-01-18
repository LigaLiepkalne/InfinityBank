<?php

namespace App\Services\Crypto;

use App\Models\Account;
use App\Models\CryptoPortfolio;
use App\Models\CryptoTransaction;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Facades\DB;

class SellCryptoService
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

        Account::find($request->getUserAccountId())->decrement('balance', $price * $request->getAmount());
        //deduct from crypto portfolio if
        CryptoPortfolio::where('bank_account_id', $accountId)
            ->where('symbol', $request->getSymbol())
            ->update([
                'amount' => DB::raw('amount - ' . $request->getAmount()),
                'total' => DB::raw('total - ' . ($price * $request->getAmount())),
                'price' => $price,
            ]);

        CryptoTransaction::create([
            'bank_account_id' => $accountId,
            'symbol' => $request->getSymbol(),
            'price' => $price,
            'amount' => $request->getAmount(),
            'total' => $price * $request->getAmount(),
            'type' => 'Sell',
            'profit_loss' => $price * $request->getAmount() - CryptoPortfolio::where('bank_account_id', $accountId)
                    ->where('symbol', $request->getSymbol())->first()->avg_price * $request->getAmount(),
            ]);

        if (CryptoPortfolio::where('bank_account_id', $accountId)
                ->where('symbol', $request->getSymbol())
                ->value('amount') == 0) {
            CryptoPortfolio::where('bank_account_id', $accountId)
                ->where('symbol', $request->getSymbol())
                ->delete();
        }

    }
}
