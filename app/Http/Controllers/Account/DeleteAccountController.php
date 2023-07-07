<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DeleteAccountController extends Controller
{
    public function confirm(Account $account): View
    {
        return view('accounts.confirm-delete', ['account' => $account]);
    }

    public function destroy(Account $account): RedirectResponse
    {
        if ($account->balance == 0.00) {
            $account->delete();
            $message = ['type' => 'success', 'text' => 'Account deleted successfully.'];
        } else {
            $message = ['type' => 'error', 'text' => 'Cannot delete account with a non-zero balance.'];
        }
        return redirect()->route('accounts.index')->with('message', $message);
    }
}
