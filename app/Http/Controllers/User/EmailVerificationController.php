<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{

    public function verifyEmailToken(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        if (! $user = User::firstWhere(['email_token' => $request->token])) {
            return $this->badRequestResponse('Email token has been used.');
        }

        $user->update([
            'email_token' => null,
            'registration_completed' => true,
        ]);

        return $this->okResponse('Email verified successfully.', $user);
    }
}