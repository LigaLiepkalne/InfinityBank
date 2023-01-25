<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoTransaction extends Model
{
    use HasFactory;

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    protected $fillable = [
        'bank_account_id',
        'symbol',
        'price',
        'amount',
        'total',
        'type',
        'profit_loss',
    ];
}
