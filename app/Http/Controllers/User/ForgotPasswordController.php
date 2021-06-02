<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\PasswordResetMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if (! $user = User::firstWhere(['email' => $request->email])) {
            return $this->notFoundResponse('Email does not exist.');
        }

        $reset = $this->createToken($user);

        Mail::to($request->email)->send(new PasswordResetMail($user, $reset));

        return $this->okResponse('Reset password link has been sent to your email.');
    }

    private function createToken(User $user): PasswordReset
    {
        return PasswordReset::create([
            'token' => Str::random(40),
            'email' => $user->email,
        ]);
    }

}