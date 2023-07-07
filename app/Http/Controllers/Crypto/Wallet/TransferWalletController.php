<?php

namespace App\Http\Controllers\Crypto\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class TransferWalletController extends Controller
{
    public function showDepositForm(): View
    {
        $wallet = $this->getUserWallet();
        $accounts = $this->getUserAccounts();

        return view('crypto.deposit', compact('wallet', 'accounts'));
    }

    public function deposit(Request $request): RedirectResponse
    {
        $amount = $request->input('amount');
        $account = $this->getAccountById($request->input('account'));
        $wallet = $this->getUserWallet();

        if ($account->balance < $amount) {
            $message = ['type' => 'error', 'text' => 'Insufficient balance.'];
            return redirect()->back()->with('message', $message);
        }

        $account->balance -= $amount;
        $account->save();

        $wallet->balance += $amount;
        $wallet->save();

        $message = ['type' => 'success', 'text' => 'Deposit successful'];
        return redirect()->route('wallet')->with('message', $message);
    }

    public function showWithdrawForm(): View
    {
        $wallet = $this->getUserWallet();
        $accounts = $this->getUserAccounts();

        return view('crypto.withdraw', compact('wallet', 'accounts'));
    }

    public function withdraw(Request $request): RedirectResponse
    {
        $amount = $request->input('amount');
        $wallet = $this->getUserWallet();
        $account = $this->getAccountById($request->input('account'));

        if ($wallet->balance < $amount) {
            $message = ['type' => 'error', 'text' => 'Insufficient balance.'];
            return redirect()->back()->with('message', $message);
        }

        $account->balance += $amount;
        $account->save();

        $wallet->balance -= $amount;
        $wallet->save();

        $message = ['type' => 'success', 'text' => 'Withdraw successful'];
        return redirect()->route('wallet')->with('message', $message);
    }

    private function getUserWallet(): CryptoWallet
    {
        $userId = Auth::user()->id;
        return CryptoWallet::where('user_id', $userId)->first();
    }

    private function getUserAccounts(): Collection
    {
        $userId = Auth::user()->id;
        return Account::where('user_id', $userId)->get();
    }

    private function getAccountById(int $accountId): Account
    {
        return Account::where('id', $accountId)->first();
    }
}
