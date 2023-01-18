<?php

namespace App\Http\Controllers\Crypto;

use App\Models\Account;
use App\Models\CryptoPortfolio;
use Illuminate\View\View;

class CryptoPortfolioController
{
    public function show(string $id): View
    {
        $userBankAccount = Account::where('id', $id)->where('user_id', auth()->id())->first();
        $cryptoPortfolio = CryptoPortfolio::where('bank_account_id', $userBankAccount->id)->get();


        //$totalValue = $this->cryptoPortfolioService->getTotalValue($portfolio);

        return view('crypto.show-portfolio', [
            'cryptoPortfolio' => $cryptoPortfolio,
            //'totalValue' => $totalValue,
        ]);
    }


    //show all user crypto per bank account
    /*
    public function index()
    {
        $user = auth()->user();
        $bankAccounts = $user->bankAccounts;
        $cryptoCollection = new CryptoCollection();
        foreach ($bankAccounts as $bankAccount) {
            $crypto = $bankAccount->crypto;
            $cryptoCollection->add($crypto);
        }
        $currencies = $cryptoCollection->getAll();
        return view('crypto.index', compact('currencies'));
    }
    */


        //store crypto in database
/*
    public function store(Request $request)
        {
            $user = auth()->user();
            $bankAccount = $user->bankAccounts->find($request->bank_account_id);
            $crypto = new Crypto();
            $crypto->bank_account_id = $bankAccount->id;
            $crypto->name = $request->name;
            $crypto->symbol = $request->symbol;
            $crypto->amount = $request->amount;
            $crypto->price = $request->price;
            $crypto->save();
            return redirect()->route('crypto.index');
        }
*/



}
