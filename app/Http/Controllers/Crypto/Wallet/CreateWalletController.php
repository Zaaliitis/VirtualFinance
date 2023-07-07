<?php

namespace App\Http\Controllers\Crypto\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateWalletController extends Controller
{
    public function create(): View
    {
        return view('crypto.create');
    }

    public function store(Request $request): RedirectResponse
    {
        CryptoWallet::create([
            'user_id' => Auth::user()->id,
            'name' => $request->input('name'),
            'wallet_number' => $this->generateWalletNumber(),
            'balance' => 0,
        ]);

        return redirect('/crypto');
    }
    private function generateWalletNumber(): string
    {
        $generatedNumbers = '';
        for ($i = 0; $i < 10; $i++) {
            $randomDigit = rand(0, 9);
            $generatedNumbers .= $randomDigit;
        }

        return auth()->user()->id . 'CRYPTO' . $generatedNumbers;
    }
}
