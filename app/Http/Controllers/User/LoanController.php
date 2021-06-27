<?php
namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LoanEligibility;
use App\Http\Controllers\Controller;
use App\Http\Actions\LoanRequestAction;

class LoanController extends Controller
{
    public function checkEligibility(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1|max:10000']);

        $user = User::with('loanEligible')->where('id', auth()->user()->id)->first();

        $rangeFrom = $user->loanEligible->range_from;
        $rangeTo = $user->loanEligible->range_to;

        if( $request->amount >= $rangeFrom && $request->amount <= $rangeTo)
        {
           return $this->okResponse("You are eligible to borrow ",$request->amount);
        }
        return $this->badRequestResponse("Sorry you are yet to qualify to borrow {$request->amount} ");
    }

    public function store(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1|max:10000']);

       $response = (new LoanRequestAction())->execute($request);

       return $this->okResponse("Your loan request is been processed",$response);
    }
}