<?php

use App\Http\Controllers\Accounts\AccountController;
use App\Http\Controllers\Accounts\AccountOperationsController;
use App\Http\Controllers\Accounts\CloseAccountController;
use App\Http\Controllers\Accounts\OpenAccountController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Crypto\CryptoController;
use App\Http\Controllers\Crypto\TradeController;
use App\Http\Controllers\Transactions\CryptoTransactionController;
use App\Http\Controllers\Transactions\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AccountController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('accounts/{id}', [AccountController::class, 'show'])->middleware(['auth'])->name('show');

Route::put('accounts/{id}/edit', [AccountOperationsController::class, 'updateLabel'])->middleware(['auth'])->name('update');
Route::delete('accounts/{id}/delete', [CloseAccountController::class, 'deleteAccount'])->middleware(['auth'])->name('delete');

Route::get('transfer', [AccountOperationsController::class, 'showTransferForm'])->middleware(['auth'])->name('transfer');
Route::post('transfer', [AccountOperationsController::class, 'transfer'])->middleware(['auth'])->name('transfer');

Route::get('/api/to_currency', [AccountOperationsController::class, 'showRecipientCurrency']);

Route::get('/accounts', [OpenAccountController::class, 'createAccountForm'])->middleware(['auth'])->name('accounts.create');
Route::post('/accounts', [OpenAccountController::class, 'storeAccount'])->middleware(['auth'])->name('accounts.store');

Route::get('/transactions', [TransactionController::class, 'index'])->middleware(['auth'])->name('transactions.index');
Route::get('crypto/transactions', [CryptoTransactionController::class, 'index'])->middleware(['auth'])->name('crypto-transactions.index');

Route::get('/trade', [CryptoController::class, 'index'])->middleware(['auth'])->name('crypto.index');
Route::get('/trade/search', [CryptoController::class, 'show'])->middleware(['auth'])->name('crypto.show');

Route::get('/trade/{symbol}/show', [CryptoController::class, 'showByCurrency'])->middleware(['auth'])->name('crypto.showByCurrency');

Route::post('/trade/{symbol}/buy', [TradeController::class, 'buy'])->name('crypto.buy');
Route::post('/trade/{symbol}/sell', [TradeController::class, 'sell'])->name('crypto.sell');

require __DIR__.'/auth.php';
