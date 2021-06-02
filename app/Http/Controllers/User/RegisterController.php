<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Str;
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

        event(new UserRegistered($user, $callback_url));

        return $this->okResponse('Registration successful.', []);
    }

    private function create($request): User
    {
        return  User::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email ,
            'password' => Hash::make($request->password),
            'email_token' => Str::random(10),
        ]);
    }

    private function validation($request)
    {
        return $request->validate([
            'firstname' => 'required|string|min:3|max:100',
            'lastname' => 'required|string|min:3|max:100',
            'email' => 'required|string|min:3|max:100',
            'callback_url' => 'required|string',
            'password' => ['required', 'min:6', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:18 years ago'],
           // 'password.regex' => 'It must contain at least one uppercase letter, one lowercase letter, one number and one special char',

        ]);
    }
}
