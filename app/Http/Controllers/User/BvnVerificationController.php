<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\BvnVerification;
use App\Http\Clients\Flutterwave;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class BvnVerificationController extends Controller
{
    /**
     * Verifies a business bvn.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @returns
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(['bvn' => 'required|numeric|digits:11']);

         $bvnStatus = BvnVerification::where('user_id', auth()->user()->id)->exists();

        if ($bvnStatus) {
            return $this->badRequestResponse('The BVN for this user has been verified already');
        }

        $response =   (new Flutterwave())->verifyBvn($request->bvn); 
        dd($response);

        if (! is_array($response)) {
            return $this->clientErrorResponse('Your bvn is invalid. Kindly confirm the number and try again.');
        }

        return $this->createdResponse('Bvn details was successfully added', $this->create($response, $request));
    }

    private function create($response, $request)
    {
        return BvnVerification::create([
            'user_id' => auth()->user()->id,
            'bvn' => $request->bvn,
            'email' => $response['email'],
            'first_name' => $response['first_name'],
            'last_name' => $response['last_name'],
            'phone' => $response['phone'],
            'date_of_birth' => $response['date_of_birth'],
            'enrollment_bank' => $response['enrollment_bank'],
            'enrollment_bank_branch' => $response['enrollment_bank_branch'],
        ]);
    }


}
