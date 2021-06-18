<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\BlacklistController;
use App\Http\Controllers\User\InitiateRepaymentController;
use App\Http\Controllers\User\VerificationController;
use App\Http\Controllers\User\CreateAccountController;
use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\BvnVerificationController;
use App\Http\Controllers\User\EmailVerificationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);
//Route::post('verify-email', [VerificationController::class, 'verifyEmailToken']);
Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('verify-otp', [VerificationController::class, 'verifyOneTimePassword']);

//Authenticated routes
Route::group(['middleware' => ['auth:sanctum' ]], function(){
    Route::post('verify-bvn', [BvnVerificationController::class, 'store']);
    Route::post('search-with-bvn', [BlacklistController::class, 'store']);
    Route::post('account-number', [AccountController::class, 'createAccountNumber']);


});
Route::post('account-creation', [CreateAccountController::class, 'store']);
Route::post('initiate-repayment', [InitiateRepaymentController::class, 'store']);
