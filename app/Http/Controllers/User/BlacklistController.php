<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Clients\Blacklist;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BlacklistController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        $request->validate(['bvn' => 'required|numeric|digits:11']);

        $response =   (new Blacklist())->searchWithBvn($request->bvn); 

        return $this->okResponse('Blacklist details was successfully verified', $response);
    }

}
