<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'received_currency',
        'sent_currency',
        'conversion_rate',
        'received_amount',
        'sent_amount',
        'recipient_account',
        'sender_account',
        'sender_name',
        'sender_surname',
        'recipient_name',
        'recipient_surname',
        'details',
        'type',
    ];
}
