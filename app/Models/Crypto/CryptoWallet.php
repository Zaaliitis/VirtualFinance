<?php

namespace App\Models\Crypto;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CryptoWallet extends Model
{
    use HasFactory;
    protected $table = 'crypto_wallets';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'name', 'wallet_number', 'balance'];
    public function currencies(): HasMany
    {
        return $this->hasMany(CryptoCurrency::class);
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
