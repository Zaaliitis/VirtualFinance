<?php

namespace App\Http\Controllers\Crypto\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoCurrency;
use App\Models\Crypto\CryptoRepository;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ShowWalletController extends Controller
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }
    public function show(): View
    {
        $wallet = $this->getUserWallet();
        $ownedCurrencies = $this->getOwnedCurrencies($wallet);
        $currencyRepository = $this->cryptoRepository->getRealTimeCurrencyResponse();
        $totalValue = $this->calculateTotalValue($ownedCurrencies, $currencyRepository);

        return view('crypto.wallet', compact('wallet', 'ownedCurrencies', 'currencyRepository', 'totalValue'));
    }

    private function getUserWallet(): CryptoWallet
    {
        $userId = Auth::user()->id;
        return CryptoWallet::where('user_id', $userId)->first();
    }

    private function getOwnedCurrencies(CryptoWallet $wallet): Collection
    {
        return CryptoCurrency::where('wallet_id', $wallet->id)->get();
    }

    private function calculateTotalValue(Collection $ownedCurrencies, array $currencyRepository): float
    {
        $totalValue = 0;

        foreach ($ownedCurrencies as $currency) {
            $cryptoCurrency = $this->findCryptoCurrency($currency->symbol, $currencyRepository);

            if ($cryptoCurrency) {
                $value = $cryptoCurrency->quote->EUR->price * $currency->amount;
                $totalValue += $value;
            }
        }

        return $totalValue;
    }

    private function findCryptoCurrency(string $symbol, array $currencyRepository): ?object
    {
        foreach ($currencyRepository as $cryptoCurrency) {
            if ($cryptoCurrency->symbol === $symbol) {
                return $cryptoCurrency;
            }
        }

        return null;
    }
}
