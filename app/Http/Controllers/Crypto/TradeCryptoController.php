<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoCurrency;
use App\Models\Crypto\CryptoRepository;
use App\Models\Crypto\CryptoTransaction;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TradeCryptoController extends Controller
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }
    public function buy(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $cryptoCurrencies = $this->cryptoRepository->getRealTimeCurrencyResponse();

        $cryptoCurrency = collect($cryptoCurrencies)->firstWhere('id', $id);
        $amount = $request->input('quantity');

        $priceInEur = $amount * $cryptoCurrency->quote->EUR->price;

        $wallet = CryptoWallet::where('user_id', $user->id)->first();
        if ($wallet->balance >= $priceInEur) {
            $wallet->balance -= $priceInEur;
            $wallet->save();
        } else {
            $message = ['type' => 'error', 'text' => 'Not enough balance.'];
            return redirect()->back()->with('message', $message);
        }

        $existingCryptoCurrency = CryptoCurrency::where('symbol', $cryptoCurrency->symbol)->first();

        if ($existingCryptoCurrency) {
            $existingCryptoCurrency->increment('amount', $amount);
        } else {
            $this->createCryptoCurrency(
                $user->wallet->id,
                $cryptoCurrency->name,
                $cryptoCurrency->symbol,
                $amount
            );
        }
        $this->createTransaction(
            $user->id,
            $user->wallet->id,
            $cryptoCurrency->id,
            'buy',
            $amount,
            $cryptoCurrency->symbol,
            $cryptoCurrency->quote->EUR->price,
            $amount * $cryptoCurrency->quote->EUR->price
        );

        $message = ['type' => 'success', 'text' => 'Crypto currency bought.'];
        return redirect()->back()->with('message', $message);
    }


    public function sell(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $cryptoCurrencies = $this->cryptoRepository->getRealTimeCurrencyResponse();

        $cryptoCurrency = collect($cryptoCurrencies)->firstWhere('id', $id);

        $amountToSell = $request->input('quantity');
        $priceInEur = $amountToSell * $cryptoCurrency->quote->EUR->price;

        $ownedCryptoCurrency = CryptoCurrency::where('symbol', $cryptoCurrency->symbol)
            ->where('wallet_id', $user->wallet->id)
            ->first();

        $wallet = CryptoWallet::where('user_id', $user->id)->first();

        if ($ownedCryptoCurrency) {
            if ($ownedCryptoCurrency->amount >= $amountToSell) {
                $wallet->balance += $priceInEur;
                $wallet->save();
                $ownedCryptoCurrency->decrement('amount', $amountToSell);
                if ($ownedCryptoCurrency->amount == 0) {
                    $ownedCryptoCurrency->delete();
                }
            } else {
                $message = ['type' => 'error', 'text' => 'Insufficient amount to sell.'];
                return redirect()->back()->with('message', $message);
            }
        } else {
            $message = ['type' => 'error', 'text' => 'You do not own this crypto currency.'];
            return redirect()->back()->with('message', $message);
        }

        $this->createTransaction(
            $user->id,
            $user->wallet->id,
            $cryptoCurrency->id,
            'sell',
            $amountToSell,
            $cryptoCurrency->symbol,
            $cryptoCurrency->quote->EUR->price,
            $amountToSell * $cryptoCurrency->quote->EUR->price
        );

        $message = ['type' => 'success', 'text' => 'Crypto currency sold.'];
        return redirect()->back()->with('message', $message);
    }

    private function createTransaction($userId, $walletId, $cryptoId, $type, $amount, $symbol, $price, $sum): void
    {
        CryptoTransaction::create([
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'crypto_id' => $cryptoId,
            'type' => $type,
            'amount' => $amount,
            'symbol' => $symbol,
            'price' => $price,
            'sum' => $sum
        ]);
    }
    private function createCryptoCurrency($walletId, $name, $symbol, $amount): void
    {
        CryptoCurrency::create([
            'wallet_id' => $walletId,
            'name' => $name,
            'symbol' => $symbol,
            'amount' => $amount,
        ]);
    }
}
