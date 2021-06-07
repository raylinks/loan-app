<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function verifyOneTimePassword(Request $request): JsonResponse
    {

        $request->validate([
            'token' => 'required|string',
        ]);
        $redirect = '';

        if (request()->redirect_callback) {
            $redirect = base64_decode($request->redirect_callback);
        }

        $token = Token::where('token', $request->token)->first();

        if (! $token) {
            return $this->notFoundResponse('Invalid Token Provided');
        }

        if ($this->otpValidation($token)) {
            $user = User::where('id', $token->user_id)->first();
            $user->update(['registration_completed' => true]);
            $token->delete();

        
            return $this->okResponse('Your phone number has been verified', []);
        }
        return $this->forbiddenResponse("Sorry Your OTP has expired.', 'expired_otp");
    }

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

    private function otpValidation($token)
    {
        $now = Carbon::now();
        $diff = $now->diffInMinutes($token->updated_at);

        return $diff < 5 && 0 === $token->is_used;
    }
}