<?php

namespace App\Models\Account;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $fillable = ['account_number', 'balance', 'currency', 'user_id', 'name'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function sentTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_account_id');
    }

    public function receivedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'receiver_account_id');
    }

}

