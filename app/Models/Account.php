<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HigherOrderCollectionProxy;

class Account extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cryptoPortfolio(): HasOne
    {
        return $this->hasOne(CryptoPortfolio::class);
    }

    public function cryptoTransaction(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class);
    }

    protected $fillable = [
        'user_id',
        'number',
        'balance',
        'currency',
    ];
/*
    public function getUserBankAccounts($userId)
    {
        return Account::where('user_id', $userId)->get();
    }
*/

    public function getUserBankAccounts(): Collection
    {
            //return Account::where('user_id', Auth::id())->get();
        return Account::where('user_id', auth()->id())->get();
    }

    public function getCurrencySymbolAttribute(): string
    {
        //HigherOrderCollectionProxy::class->has('currency');
        $numbers = collect([1, 2, 3, 4, 5]);
        return $this->currency === 'USD' ? '$' : '€';
    }

}
