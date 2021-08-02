<?php

namespace App\Http\Controllers\User;

use App\Http\Clients\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Clients\Monnify;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PayWithCardRequest;
use Illuminate\Auth\AuthenticationException;

class PayWithCardController extends Controller
{
    public function store()
    {
        $tokenResponse = (new AuthRequest())->token();
        dd($tokenResponse);


        $response = (new Monnify($tokenResponse))->payWithCard();
    }
}
