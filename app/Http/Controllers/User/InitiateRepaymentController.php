<?php

namespace App\Http\Controllers\User;

use App\Http\Actions\InitiateRepaymentAction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Clients\Monnify;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PayWithCardRequest;
use Illuminate\Auth\AuthenticationException;

class InitiateRepaymentController extends Controller
{
    public function store(PayWithCardRequest $request)
    {
        $response = (new InitiateRepaymentAction())->execute($request);

    }
}