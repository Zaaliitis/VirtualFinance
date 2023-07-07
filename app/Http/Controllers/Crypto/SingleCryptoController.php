<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoCurrency;
use App\Models\Crypto\CryptoRepository;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class SingleCryptoController extends Controller
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function show($id): View
    {
        $cryptoCurrencies = $this->cryptoRepository->getRealTimeCurrencyResponse();
        $wallet = CryptoWallet::where('user_id', Auth::user()->id)->first();
        $cryptoCurrency = collect($cryptoCurrencies)->firstWhere('id', $id);
        $ownedCurrencies = CryptoCurrency::where('wallet_id', $wallet ? $wallet->id : null)->get();

        return view('crypto.show', compact('cryptoCurrency', 'wallet', 'ownedCurrencies'));
    }
}
