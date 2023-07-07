<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use App\Models\Account\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show(Request $request, Account $account): View
    {
        if ($account->user_id !== auth()->user()->id) {
            abort(404);
        }
        $transactions = $this->getTransactionsQuery($account, $request)->get();

        return view('accounts.transaction-history', [
            'transactions' => $transactions,
            'account' => $account
        ]);
    }

    private function getTransactionsQuery(Account $account, Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $searchTerm = $request->input('search');

        return Transaction::join('accounts AS sender_account', 'transactions.sender_account_id', '=', 'sender_account.id')
            ->join('accounts AS receiver_account', 'transactions.receiver_account_id', '=', 'receiver_account.id')
            ->select('transactions.*')
            ->where(function ($query) use ($account) {
                $query->where(function ($query) use ($account) {
                    $query->where('sender_account.id', $account->id)
                        ->orWhere('receiver_account.id', $account->id);
                });
            })
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('transactions.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('transactions.created_at', '<=', $endDate);
            })
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('transactions.name', 'like', "%{$searchTerm}%")
                        ->orWhere('transactions.description', 'like', "%{$searchTerm}%")
                        ->orWhere('transactions.amount', 'like', "%{$searchTerm}%")
                        ->orWhere('sender_account.account_number', 'like', "%{$searchTerm}%")
                        ->orWhere('receiver_account.account_number', 'like', "%{$searchTerm}%");
                });
            })
            ->orderByDesc('transactions.created_at');
    }
}
