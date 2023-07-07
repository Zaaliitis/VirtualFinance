<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class IndexAccountController extends Controller
{
    private Account $account;

    public function __construct(
        Account $account,
    )
    {
        $this->account = $account;
    }

    public function index(Request $request): View | RedirectResponse
    {
        $accountId = $request->input('account');

        if ($accountId) {
            $selectedAccount = $this->account->findOrFail($accountId);
            if ($selectedAccount->user_id !== auth()->user()->id) {
                abort(404);
            }
        } else {
            $selectedAccount = null;
        }
        $userAccounts = $this->account->where('user_id', auth()->user()->id)->get();

        return view('accounts.index', ['userAccounts' => $userAccounts, 'selectedAccount' => $selectedAccount]);
    }
}
