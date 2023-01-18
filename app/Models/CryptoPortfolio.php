<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CryptoPortfolio extends Model
{
    use HasFactory;

    protected $table = 'crypto_portfolios_by_bank_account';
    protected $primaryKey = 'id';

    // one bank account has one crypto portfolio
    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // one crypto portfolio has many crypto
    public function crypto(): HasMany
    {
        return $this->hasMany(Crypto::class);
    }

    protected $fillable = [
        'bank_account_id',
        'symbol',
        'price',
        'amount',
        'total',
        'price_sum',
        'purchase_count',
        'avg_price',
    ];
}
