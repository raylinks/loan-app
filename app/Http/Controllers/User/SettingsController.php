<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserBankAccount;
use App\Http\Clients\Flutterwave;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateProfileRequest;


class SettingsController extends Controller
{

    public function createProfile(CreateProfileRequest $request)
    {
       $user = User::where('id' ,auth()->user()->id)->first();

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

       return $this->okResponse('Profile created successfully', $profile );
       
    }

    public function uploadeBankStament(Request $request)
    {
       $user = User::where('id',auth()->user()->id)->first();
       dd($user);
       $user->details->create([

       ]);
       
    }

    public function getAccountName(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|max:10|min:10',
            'bank_code' => 'required|string|max:10|exists:banks,code',
        ]);

        $requestData = $request->only(['account_number', 'bank_code']);
        
        $result = (new Flutterwave())->getAccountName($requestData);

        return $this->okResponse('Account name  retrieved successfully', $result );
    }

    public function createUserBankAccount(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|max:10|min:10',
            'bank_code' => 'required|string|max:10|exists:banks,code'
        ]);
        # code...
        //check if user already has bank account

        $bankAccount = UserBankAccount::where(['account_number' => $request->account_number])->exists(); 

        if($bankAccount){
            return $this->forbiddenResponse('This account number has been registered already');
        } 

        $result = (new Flutterwave())->getAccountName($request->account_number, $request->bank_code);

        if ($result['status'] === 200) {
            $enquiry_result = ['data' => ['statuscode' => '00', 'data' => [
                'accountName' => data_get($result, 'data.data.fullname'),
                'accountNumber' => data_get($result, 'data.data.account_number'),
            ]]];
        }

        $user = User::where('id', auth()->user()->id)->first();

        $user->bankAccount->create([
            ''

        ]);




    }


}