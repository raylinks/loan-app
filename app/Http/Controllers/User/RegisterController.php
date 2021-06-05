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

class RegisterController extends Controller
{
    
    public function store(Request $request): JsonResponse
    {
     
       //$this->validation($request);

        $user = $this->create($request);
       
        $user->details()->save((new UserDetail()));

        $callback_url = $request->callback_url;

        $sendOtp  = $this->sendOtp($user, $request);

        //event(new UserRegistered($user, $callback_url));

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

    private function validation($request)
    {
        return $request->validate([
            'firstname' => 'required|string|min:3|max:100',
            'lastname' => 'required|string|min:3|max:100',
            'email' => 'required|string|min:3|max:100',
            'callback_url' => 'required|string',
            'password' => ['required', 'string', 'confirmed', new ValidPassword()],
          //  'date_of_birth' => ['required', 'date', 'before_or_equal:18 years ago'],
            'phone_number' => 'required|string|unique:users',
           // 'password.regex' => 'It must contain at least one uppercase letter, one lowercase letter, one number and one special char',

        ]);
    }

    private function sendOtp($user ,$request)
    {
        $user->token()->create([
            'user_id' => $user->id,
            'token' => random_int(100000, 999999),
            'is_used' => false,
        ]);

        $otp = new Otp();

        $otp->channel = $request->channel ?: Otp::DEFAULT_SMS_CHANNEL;

        $phone = $otp->formatPhone($user->phone_number, $user->id, Otp::DEFAULT_CODE);

        $text = sprintf(
            'Hi %s! Your OTP pin is %s. Please know that this OTP expires in 5 minutes.',
            $user->first_name,
            $otp->token
        );

        $otp->sendOtp($phone, $otp->token, $text, $user->first_name, $isRegistration = false);
    }

}
