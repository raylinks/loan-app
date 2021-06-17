<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Clients\Monnify;
use App\Http\Clients\Blacklist;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{

    public function createAccountNumber(Request $request): JsonResponse
    {
       
       // $request->validate(['bvn' => 'required|numeric|digits:11']);

        $response =   (new Monnify())->createCustomAccount($request->bvn); 
        dd($response);

        return $this->okResponse('Account created successfully', $response);
    }

}
