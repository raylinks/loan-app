<?php

namespace App\Http\Controllers\User;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserBankAccount;
use App\Http\Clients\Flutterwave;
use App\Http\Actions\SettingsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProfileRequest;


class SettingsController extends Controller
{
    public function createProfile(CreateProfileRequest $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        $profile = $user->details->update([
            'title' => $request->title,
            'marital_status' => $request->marital_status,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'current_employment' => $request->current_employment,
            'occupation' => $request->occupation,
            'years_of_employment' => $request->years_of_employment,
            'monthly_income' => $request->monthly_income,
        ]);

        return $this->okResponse('Profile created successfully', $profile);
    }

    public function uploadeBankStament(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        $user->details->create([]);
    }

    public function getAccountName(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|max:10|min:10',
            'bank_code' =>  'required', //'required|string|max:10|exists:banks,code',
        ]);

        $requestData = $request->only(['account_number', 'bank_code']);

        $result = (new Flutterwave())->getAccountName($requestData);

        return $this->okResponse('Account name  retrieved successfully', $result);
    }

    public function createUserBankAccount(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|max:10|min:10',
            'bank_code' => 'required|string|max:10|exists:banks,code'
        ]);

        $hasAccount = UserBankAccount::where(['account_number' => $request->account_number])->exists();

        if ($hasAccount) {
            return $this->forbiddenResponse('This account number has been registered already');
        }

        $response = (new SettingsAction())->execute($request);

        return $this->okResponse('Profile created successfully', $response);
    }

    public function getAllBanks()
    {
        $banks = Bank::all();

        return $this->okResponse('Banks  retrieved successfully', $banks);
    }
}
