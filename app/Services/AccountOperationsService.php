<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Collections\AccountsCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AccountOperationsService
{
    private Account $userBankAccounts;

    public function __construct(Account $userBankAccounts)
    {
        $this->userBankAccounts = $userBankAccounts;
    }

    //get user bank account and return model BankAcocunt

    /*
    public function getUserBankAccounts(): AccountsCollection
    {
        return new AccountsCollection($this->userBankAccounts->all());
    }
    */

    /*
    public function getUserBankAccounts(): AccountsCollection
    {
        $userBankAccounts = $this->userBankAccounts->where(function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return new AccountsCollection($userBankAccounts->toArray());
    }
*/
/*
    public function getUserBankAccounts(): AccountsCollection
    {
        $userBankAccounts = $this->userBankAccounts->where(function($query) {
            $query->where('user_id', auth()->id());
        })->get()->toArray();

        $bankAccountsCollection = new AccountsCollection();

        foreach ($userBankAccounts as $bankAccount) {
            $bankAccountModel = new Account($bankAccount);
            $bankAccountsCollection->add($bankAccountModel);
        }

        return $bankAccountsCollection;
    }
*/

    public function getUserBankAccounts(): Collection
    {
        return $this->userBankAccounts
            ->where('user_id', auth()->id())
            ->get();
    }


    /*
    public function getBankAccountByNumber(string $number): Account
    {
        return $this->userBankAccounts->where(function($query) use ($number) {
            $query->where('user_id', auth()->id())
                ->where('number', $number);
        })->first();
    }
*/
    /*
    {
        $this->userBankAccounts = auth()->user()->bankAccounts;
    }
    */






//getUserBankAccounts

//getBankAccounts



//deposity money to user bank account identified by user ID and bank account number


    public function deposit(string $account, float $amount): void
    {
        $bankAccount = Account::where('number', $account)->firstOrFail();
        $bankAccount->balance += $amount;
        $bankAccount->save();
    }

    public function withdraw(string $account, float $amount, string $currency): void
    {
        $bankAccount = Account::where('number', $account)->firstOrFail();
        $bankAccount->balance -= $amount;
        $bankAccount->save();
    }


    public function depositBalance(Request $request): void
    {
        $amount = (float) $request->input('amount');
        $user = Auth::user();
        $bankAccount = $user->bank_account;
        $bankAccount->balance += $amount;
        $bankAccount->save();
    }

  public function transfer($get, $get1, $get2)
  {
  }

}
