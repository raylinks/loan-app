<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Clients\Flutterwave;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;


class SettingsController extends Controller
{


    public function updateProfile(UpdateProfileRequest $request)
    {
       $user = User::where('id' ,auth()->user()->id)->first();
  
       $profile = $user->details->create([
            'title' => $request->title,
            'marital_status' => $request->marital_status,
            'address' => $request->address,
            'cuurent_employment' => $request->cuurent_employment,
            'occupation' => $request->occupation,
            'years_of_employment' => $request->years_of_employment,
            'monthly_income' => $request->monthly_income,
       ]);

       return $this->okResponse('Profile updated successfully', $profile );
       
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
            'account_number' => '',
            'bank_code' => '',
        ]);
        
        $result = (new Flutterwave())->getAccountName($request->account_number, $request->bank_code);
    }

    public function createUserBankAccount()
    {
        # code...
    }


}