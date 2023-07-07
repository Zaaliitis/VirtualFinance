<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoTransaction;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ShowTradeHistoryController extends Controller
{
    public function show(): View
    {
        $wallet = CryptoWallet::where('user_id', Auth::user()->id)->first();
        $transactions = CryptoTransaction::with('cryptoCurrency')->where('wallet_id', $wallet->id)->get();

        return view('crypto.history', compact('wallet', 'transactions'));
    }
}
