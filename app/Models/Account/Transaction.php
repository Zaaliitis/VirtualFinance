<?php

namespace App\Models\Account;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'amount',
        'description',
        'name',
        'currency'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function senderAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function receiverAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
