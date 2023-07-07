<?php

namespace App\Http\Controllers\Crypto\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoCurrency;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class DeleteWalletController extends Controller
{
    public function delete(): RedirectResponse
    {
        $userId = Auth::user()->id;
        $wallet = CryptoWallet::where('user_id', $userId)->first();
        $ownedCurrencies = CryptoCurrency::where('wallet_id', $wallet->id)->get();

        if ($wallet->balance > 0) {
            $message = ['type' => 'error', 'text' => 'Cannot delete wallet with a non-zero balance.'];
            return redirect()->back()->with('message', $message);
        }

        if (!$ownedCurrencies->isEmpty()) {
            $message = ['type' => 'error', 'text' => 'Cannot delete wallet with currencies.'];
            return redirect()->back()->with('message', $message);
        }

        $wallet->delete();

        $message = ['type' => 'success', 'text' => 'Wallet deleted successfully.'];
        return redirect('/crypto')->with('message', $message);
    }
}
