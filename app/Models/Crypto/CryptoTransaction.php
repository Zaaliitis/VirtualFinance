<?php

namespace App\Models\Crypto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoTransaction extends Model
{
    use HasFactory;
    protected $table = 'crypto_transactions';
    protected $primaryKey = 'id';
    protected $fillable = ['wallet_id', 'crypto_id', 'type', 'amount','symbol' ,'price', 'sum'];
    public function wallet(): BelongsTo
    {
       return $this->belongsTo(CryptoWallet::class);
    }
    public function cryptoCurrency(): BelongsTo
    {
       return $this->belongsTo(CryptoCurrency::class);
    }

}
