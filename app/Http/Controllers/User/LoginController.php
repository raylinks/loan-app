<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;
use App\Http\Resources\LoginResource;

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
            return $this->notFoundResponse("The credentials do not match our record");
        }
        $token  = $user->createToken('my-app-token')->plainTextToken;
     
        return $this->okResponse('Login successfully', [  
             'token' => $token,
             'user' => (new LoginResource($user))->toArray($request)]);
       
    }

    // public function logout()
    // {
    //     auth()->user()->token()->delete();

    //     return $this->okResponse("Logged out  successful", []);
    // }

}