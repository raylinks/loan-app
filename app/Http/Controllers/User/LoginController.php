<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request): JsonResponse
    {
        $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if($user->registration_completed == false)
        {
            return $this->badRequestResponse("Sorry you have not verified your email");
        }

        if(!$user ||  !Hash::check($request->password, $user->password)){
            return $this->notFoundResponse("The credentials do not match our record ", $user);
        }
        $token  = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'expires_at' => '',
         //   'expires_at' => now()->addSeconds(auth()->factory()->getTTL() * 60)->timestamp,
        ];
        return $this->okResponse("Login successful", $response);
       
    }

    // public function logout()
    // {
    //     auth()->user()->token()->delete();

    //     return $this->okResponse("Logged out  successful", []);
    // }

}