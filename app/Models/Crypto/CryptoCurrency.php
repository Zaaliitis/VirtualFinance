<?php

namespace App\Models\Crypto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CryptoCurrency extends Model
{
    use HasFactory;
    protected $table = 'crypto_currencies';
    protected $primaryKey = 'id';
    protected $fillable = ['wallet_id', 'name', 'symbol', 'amount'];

    public function transactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(CryptoWallet::class, 'user_id');
    }
}
