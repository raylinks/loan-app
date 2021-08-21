<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\BlacklistController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PayWithCardController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\VerificationController;
use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\BvnVerificationController;
use App\Http\Controllers\User\EmailVerificationController;
use App\Http\Controllers\User\InitiateRepaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//header('Access-Control-Allow-Origin', '*');
// header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);
//Route::post('verify-email', [VerificationController::class, 'verifyEmailToken']);
Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('verify-otp', [VerificationController::class, 'verifyOneTimePassword']);

Route::post('auth', [PayWithCardController::class, 'store']);

//Authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('verify-bvn', [BvnVerificationController::class, 'store']);
    Route::post('search-with-bvn', [BlacklistController::class, 'store']);
    Route::post('account-number', [AccountController::class, 'createAccountNumber']);
    Route::post('create-profile', [SettingsController::class, 'createProfile']);
    Route::post('user-bank-account', [SettingsController::class, 'createUserBankAccount']);
    Route::post('account-details', [SettingsController::class, 'getAccountName']);
    Route::get('loan-eligibility', [LoanController::class, 'checkEligibility']);
    Route::post('loan-request', [LoanController::class, 'store']);
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::get('incoming/transactions', [DashboardController::class, 'incomingTransactions']);
    Route::get('outgoing/transactions', [DashboardController::class, 'outgoingTransactions']);


    Route::post('initiate-repayment', [InitiateRepaymentController::class, 'store']);
    // Route::post('account-creation', [CreateAccountController::class, 'store']);


});

Route::get('banks', [SettingsController::class, 'getAllBanks']);
