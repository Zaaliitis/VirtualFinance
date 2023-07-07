<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TwoFactorController;
use App\Http\Requests\TransferRequest;
use App\Models\Account\Account;
use App\Models\Account\CurrencyExchange;
use App\Models\Account\Transaction;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use PragmaRX\Google2FA\Google2FA;

class TransferController extends Controller
{
    private Account $account;
    private CurrencyExchange $currencyExchange;
    private Transaction $transaction;

    public function __construct(
        Account          $account,
        CurrencyExchange $currencyExchange,
        Transaction      $transaction
    )
    {
        $this->account = $account;
        $this->currencyExchange = $currencyExchange;
        $this->transaction = $transaction;
    }
    public function showForm(): View
    {
        $user = auth()->user();
        $userId = $user->id;
        $userAccounts = $this->account->where('user_id', $userId)->get();
        $qrCode = TwoFactorController::generateQRCode();

        return view('accounts.transfer', [
            'userAccounts' => $userAccounts,
            'qrCode' => $qrCode,
            'user' => $user,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TransferRequest $request): RedirectResponse
    {
        $senderAccount = $this->account->where(
            'account_number',
            $request->input('sender_account_number'))->first();
        $receiverAccount = $this->account->where(
            'account_number',
            $request->input('receiver_account_number'))->first();
        $amount = $request->input('amount');

        if ($senderAccount->balance < $amount) {
            $message = ['type' => 'error', 'text' => 'Insufficient balance.'];
            return redirect()->back()->with('message', $message);
        }

        if (!$this->isValidSecurityCode($request)) {
            $message = ['type' => 'error', 'text' => 'Invalid security code.'];
            return redirect()->back()->with('message', $message);
        }

        $convertedAmount = $this->convertAmount($amount, $senderAccount, $receiverAccount);

        $this->performTransfer($senderAccount, $receiverAccount, $amount, $convertedAmount, $request);

        $message = ['type' => 'success', 'text' => 'Transfer successful.'];
        return redirect()->back()->with('message', $message);
    }

    private function isValidSecurityCode(TransferRequest $request): bool
    {
        $otpCode = $request->input('security_code');
        $user = auth()->user();
        $otpSecret = $user->otp_secret;
        return !empty($otpSecret) && !empty($otpCode) && (new Google2FA)->verifyKey($otpSecret, $otpCode);
    }

    private function convertAmount(float $amount, Account $senderAccount, Account $receiverAccount): float
    {
        $receiverCurrency = $receiverAccount->currency;
        $senderCurrency = $senderAccount->currency;
        $receiverRate = $this->currencyExchange->getCurrencyRate($receiverCurrency);
        $senderRate = $this->currencyExchange->getCurrencyRate($senderCurrency);
        return $amount * $receiverRate / $senderRate;
    }

    private function performTransfer(Account $senderAccount, Account $receiverAccount, float $amount, float $convertedAmount, TransferRequest $request): void
    {
        $senderAccount->balance -= $amount;
        $receiverAccount->balance += $convertedAmount;
        $senderAccount->save();
        $receiverAccount->save();

        $this->transaction->create([
            'sender_account_id' => $senderAccount->id,
            'receiver_account_id' => $receiverAccount->id,
            'amount' => $amount,
            'description' => $request->input('description'),
            'name' => $request->input('name'),
            'currency' => $senderAccount->currency,
        ]);
    }
}
