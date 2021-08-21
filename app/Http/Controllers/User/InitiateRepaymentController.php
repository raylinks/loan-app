<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Clients\Monnify;
use App\Http\Clients\Paystack;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PayWithCardRequest;
use Illuminate\Auth\AuthenticationException;
use App\Http\Actions\InitiateRepaymentAction;

class InitiateRepaymentController extends Controller
{
    public function store(PayWithCardRequest $request)
    {
        $response = (new InitiateRepaymentAction())->execute($request);

        // $response = (new Paystack())->initiateRepayment($request->amount, $ref);

        return $this->okResponse('Repayment initiated.', $response);
    }
}
