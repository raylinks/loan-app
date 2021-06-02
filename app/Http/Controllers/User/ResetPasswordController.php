<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'password' => ['required', 'string', 'confirmed', new ValidPassword()],
        ]);

        $reset = $this->verifyToken($request->token);

        if (! $reset) {
            return $this->badRequestResponse('Invalid token or expired token');
        }

        $user = User::whereEmail($reset->email)->first();

        if (Hash::check($request->password, $user->password)) {
            return $this->badRequestResponse("Sorry you can't use your old password");
        }

        $user->update(['password' => Hash::make($request->password)]);
        PasswordReset::where(['email' => $reset->email])->delete();

        return $this->okResponse('Password reset successfully');
    }

    private function verifyToken(string $token)
    {
        $reset = PasswordReset::firstWhere(['token' => $token]);

        return ($reset && ! $reset->created_at->addHours(PasswordReset::TOKEN_EXPIRES_IN_HOURS)->isPast()) ? $reset : null;
    }

}