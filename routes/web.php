<?php

use App\Http\Controllers\Account\CreateAccountController;
use App\Http\Controllers\Account\DeleteAccountController;
use App\Http\Controllers\Account\IndexAccountController;
use App\Http\Controllers\Account\TransactionController;
use App\Http\Controllers\Account\TransferController;
use App\Http\Controllers\Crypto\IndexCryptoController;
use App\Http\Controllers\Crypto\ShowTradeHistoryController;
use App\Http\Controllers\Crypto\SingleCryptoController;
use App\Http\Controllers\Crypto\TradeCryptoController;
use App\Http\Controllers\Crypto\Wallet\CreateWalletController;
use App\Http\Controllers\Crypto\Wallet\DeleteWalletController;
use App\Http\Controllers\Crypto\Wallet\ShowWalletController;
use App\Http\Controllers\Crypto\Wallet\TransferWalletController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
//Account
//Create
Route::post('/accounts', [CreateAccountController::class, 'store'])
    ->name('accounts.store');
Route::get('/accounts/create', [CreateAccountController::class, 'create'])
    ->name('accounts.create');

//Read
Route::get('/accounts', [IndexAccountController::class, 'index'])
    ->name('accounts.index');
Route::post('/accounts/show', [IndexAccountController::class, 'index'])
    ->name('accounts.show');
Route::get('/accounts/show', [IndexAccountController::class, 'index'])
    ->name('accounts.show');

Route::post('/transaction-history/{account}', [TransactionController::class, 'show'])
    ->name('transaction-history');
Route::get('/transaction-history/{account}', [TransactionController::class, 'show'])
    ->name('transaction-history');

//Update
Route::get('/accounts/transfer', [TransferController::class, 'showForm'])
    ->name('accounts.transfer');
Route::post('/accounts/transfer', [TransferController::class, 'execute'])
    ->name('accounts.transfer');

Route::post('/verify-security-key', [TwoFactorController::class, 'verifySecurityKey'])
    ->name('verifySecurityKey');

//Delete
Route::get('/accounts/{account}/confirm-delete', [DeleteAccountController::class, 'confirm'])
    ->name('accounts.confirm-delete');
Route::delete('/accounts/{account}', [DeleteAccountController::class, 'destroy'])
    ->name('accounts.destroy');



//Crypto
//Create
Route::post('/crypto', [CreateWalletController::class, 'store'])
    ->name('crypto.store');
Route::get('/crypto/create', [CreateWalletController::class, 'create'])
    ->name('crypto.create');

//Read
Route::get('/crypto', [IndexCryptoController::class, 'index'])
    ->name('crypto.index');
Route::get('/crypto/wallet', [ShowWalletController::class, 'show'])
    ->name('wallet');
Route::get('/crypto/show/{id}', [SingleCryptoController::class, 'show'])
    ->name('crypto.show');
Route::get('/crypto/history', [ShowTradeHistoryController::class, 'show'])
    ->name('crypto.history');

//Update
Route::post('/crypto/{id}/buy', [TradeCryptoController::class, 'buy'])
    ->name('crypto.buy');
Route::post('/crypto/{id}/sell', [TradeCryptoController::class, 'sell'])
    ->name('crypto.sell');

Route::get('/crypto/deposit', [TransferWalletController::class, 'showDepositForm'])
    ->name('crypto.deposit');
Route::post('/crypto/deposit', [TransferWalletController::class, 'deposit'])
    ->name('crypto.deposit');
Route::get('/crypto/withdraw', [TransferWalletController::class, 'showWithdrawForm'])
    ->name('crypto.withdraw');
Route::post('/crypto/withdraw', [TransferWalletController::class, 'withdraw'])
    ->name('crypto.withdraw');

//Delete
Route::delete('/crypto/delete', [DeleteWalletController::class, 'delete'])
    ->name('crypto.delete');
