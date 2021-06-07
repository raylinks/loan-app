<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Services\Otp;
use App\Models\UserDetail;
use Illuminate\Support\Str;
use App\Rules\ValidPassword;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    
    public function store(RegisterRequest $request): JsonResponse
    {
     
       $this->validation($request);

        $user = $this->create($request);
       
        $user->details()->save((new UserDetail()));

        $callback_url = $request->callback_url;

        $this->sendOtp($user, $request);
    
       // event(new UserRegistered($user, $callback_url));

        return $this->okResponse('Registration successful.', []);
    }

    private function create($request): User
    {
        return  User::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email ,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'email_token' => Str::random(10),
            'registration_completed' => false
        ]);
    }

    private function sendOtp($user ,$request)
    {
        $createdToken = $user->token()->create([
            'user_id' => $user->id,
            'token' => random_int(100000, 999999),
            'is_used' => false,
        ]);

        $otp = new Otp();

        $otp->channel = $request->channel ?: Otp::DEFAULT_SMS_CHANNEL;

        $phone = $otp->formatPhone($user->phone_number, $user, Otp::DEFAULT_CODE);

        $text = sprintf(
            'Hi %s! Your OTP pin is %s. Please know that this OTP expires in 5 minutes.',
            $user->first_name,
            $createdToken->token
        );

    $otpSuccess =  $otp->sendOtp($phone, $createdToken->token, $text, $user, $isRegistration = false);
   
    }

}
