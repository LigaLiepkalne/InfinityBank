<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'label',
    ];
}
