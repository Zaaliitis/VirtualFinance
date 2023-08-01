<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use App\Models\Account\CurrencyExchange;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CreateAccountController extends Controller
{
    private Account $account;
    private CurrencyExchange $currencyExchange;

    public function __construct(
        Account          $account,
        CurrencyExchange $currencyExchange,
    )
    {
        $this->account = $account;
        $this->currencyExchange = $currencyExchange;
    }

    /**
     * @throws GuzzleException
     */
    public function create(): View
    {
        $currencies = $this->currencyExchange->getCurrency();
        return view('accounts.create', ['currencies' => $currencies]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->account->create([
            'account_number' => $this->generateAccountNumber(),
            'balance' => 10000,
            'currency' => $request->input('currency'),
            'name' => $request->input('name'),
            'user_id' => auth()->user()->id
        ]);

        return redirect('/accounts');
    }

    private function generateAccountNumber(): string
    {
        $generatedNumbers = '';
        for ($i = 0; $i < 10; $i++) {
            $randomDigit = rand(0, 9);
            $generatedNumbers .= $randomDigit;
        }

        return auth()->user()->id . 'VF' . $generatedNumbers;
    }
}
