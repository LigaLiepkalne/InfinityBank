<?php

namespace App\Http\Controllers\Crypto;

use App\Models\Account;
use App\Models\CodeCard;
use App\Rules\BalanceCheckRule;
use App\Rules\CodeMatchRule;
use App\Rules\CryptoAmountCheckRule;
use App\Services\Crypto\BuyCryptoService;
use App\Services\Crypto\CryptoService;
use App\Services\Crypto\SellCryptoService;
use App\Services\Crypto\TradeCryptoServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TradeController
{
    private CryptoService $cryptoCurrencyService;
    private BuyCryptoService $buyCryptoService;
    private SellCryptoService $sellCryptoService;

    public function __construct(CryptoService     $cryptoCurrencyService,
                                BuyCryptoService  $buyCryptoService,
                                SellCryptoService $sellCryptoService)
    {
        $this->cryptoCurrencyService = $cryptoCurrencyService;
        $this->buyCryptoService = $buyCryptoService;
        $this->sellCryptoService = $sellCryptoService;
    }

    public function buy(Request $request, string $symbol): RedirectResponse
    {
        $request->validate([
            'account' => ['required', Rule::exists('accounts', 'id')->where('user_id', auth()->id())],
            'amount' => ['required', 'numeric', 'min:0.00000001', new BalanceCheckRule($this->getPrice($request, $symbol))],
            'password' => 'required|current_password',
            'code' => ['required', new CodeMatchRule($this->getCodes())],
        ]);

        $this->buyCryptoService->execute(new TradeCryptoServiceRequest(
            $request->get('account'),
            $symbol,
            $this->getPrice($request, $symbol),
            $request->get('amount'),
        ));

        return redirect()->back()->with(
            'success', 'You have successfully bought ' . $request->get('amount') . ' ' . $symbol
        );
    }

    public function sell(Request $request, string $symbol): RedirectResponse
    {
        $request->validate([
            'account' => ['required', Rule::exists('accounts', 'id')->where('user_id', auth()->id())],
            'amount' => ['required', 'numeric', 'min:0.000001', new CryptoAmountCheckRule($request, $symbol)],
            'password' => 'required|current_password',
            'code' => ['required', new CodeMatchRule($this->getCodes())],
        ]);

        $this->sellCryptoService->execute(new TradeCryptoServiceRequest(
            $request->get('account'),
            $symbol,
            $this->getPrice($request, $symbol),
            $request->get('amount'),
        ));

        return redirect()->back()->with(
            'success', 'You have successfully sold ' . $request->get('amount') . ' ' . $symbol
        );
    }

    public function getCodes(): array
    {
        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        return array_combine(range(1, count($codes)), $codes);
    }

    public function getPrice(Request $request, string $symbol): float
    {
        $accountCurrency = Account::where('id', $request->get('account'))->value('currency');
        return $this->cryptoCurrencyService->getSingleCrypto($symbol, $accountCurrency)->getPrice();
    }
}
