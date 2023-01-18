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

    public function __construct(CryptoService $cryptoCurrencyService,
                                BuyCryptoService $buyCryptoService,
                                SellCryptoService $sellCryptoService)
    {
        $this->cryptoCurrencyService = $cryptoCurrencyService;
        $this->buyCryptoService = $buyCryptoService;
        $this->sellCryptoService = $sellCryptoService;
    }

/*
    public function showBuyForm(string $symbol): View
    {
        $crypto = $this->cryptoCurrencyService->getSingleCrypto($symbol);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        return view('crypto.buy', [
            'crypto' => $crypto,
            'userBankAccounts' => $userBankAccounts,
            'codeIndex' => $codeIndex,
            'codes' => $codes,
        ]);
    }
*/
    public function buy(Request $request, string $symbol): RedirectResponse
    {
        $accountCurrency = Account::where('id', $request->get('account'))->value('currency');
        $price = $this->cryptoCurrencyService->getSingleCrypto($symbol, $accountCurrency)->getPrice();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $request->validate([
            'account' => ['required', Rule::exists('accounts', 'id')->where('user_id', auth()->id())],
            'amount' => ['required', 'numeric', 'min:0.00000001', new BalanceCheckRule($price)],
            'password' => 'required|current_password',
            'code' => ['required', new CodeMatchRule($codes)],
        ]);

        $this->buyCryptoService->execute(new TradeCryptoServiceRequest(
            $request->get('account'),
            $symbol,
            $price,
            $request->get('amount'),
        ));

        return redirect()->back()->with('success', 'You have successfully bought ' . $request->get('amount') . ' ' . $symbol);
    }
/*
    public function showSellForm(string $symbol): View
    {
        $crypto = $this->cryptoCurrencyService->getSingleCrypto($symbol);

        $userBankAccounts = Account::where('user_id', auth()->id())->get();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);
        $codeIndex = rand(1, count($codes));

        return view('crypto.sell', [
            'crypto' => $crypto,
            'userBankAccounts' => $userBankAccounts,
            'codeIndex' => $codeIndex,
            'codes' => $codes,
        ]);
    }
*/
    public function sell(Request $request, string $symbol): RedirectResponse
    {
        $accountCurrency = Account::where('id', $request->get('account'))->value('currency');
        $price = $this->cryptoCurrencyService->getSingleCrypto($symbol, $accountCurrency)->getPrice();

        $codeCard = CodeCard::where('user_id', auth()->id())->first();
        $codes = json_decode($codeCard->codes);
        $codes = array_combine(range(1, count($codes)), $codes);

        $request->validate([
            'account' => ['required', Rule::exists('accounts', 'id')->where('user_id', auth()->id())],
            'amount' => ['required', 'numeric', 'min:0.00000001', new CryptoAmountCheckRule($request, $symbol)],
            'password' => 'required|current_password',
            'code' => ['required', new CodeMatchRule($codes)],
        ]);

        $this->sellCryptoService->execute(new TradeCryptoServiceRequest(
            $request->get('account'),
            $symbol,
            $price,
            $request->get('amount'),
        ));

        return redirect()->back()->with('success', 'You have successfully sold ' . $request->get('amount') . ' ' . $symbol);
    }

    /*
     public function buy(array $vars)
     {

         $price = $this->cryptoCurrenciesService->getSingleCrypto($vars['symbol'])->getPrice();

         public
         function showSenderBalance(Request $request): JsonResponse
         {
             //$accountNumber = $request->input('from_account'); //accountNumber
             // $account = Account::where('number', $request->get('from_account'))->first();
             //return response()->json(['balance' => $account->balance]);
             $balance = Account::where('number', $request->get('from_account'))->value('balance');
             return response()->json(['balance' => $balance]);
         }


    }

*/
}
