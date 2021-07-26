<?php
namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\LoanEligible;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Actions\LoanRequestAction;
use App\Models\LoanRequest;

class LoanController extends Controller
{
    public function checkEligibility(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1|max:100000']);

        $totalPaid = Auth::user()->eligible_amount;
        
        $loan = LoanEligible::where('range_to', '>=', $totalPaid)->where('range_from', '<=', $totalPaid)->value('amount');

        if ($request->amount > $loan)
        {
            return $this->badRequestResponse("Sorry you are yet to qualify to borrow {$request->amount} ");
           
        }
        return $this->okResponse("you are eligible to borrow {$request->amount}");
      
    
    }

    public function store(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1|max:100000']);

        $loanStatus = LoanRequest::where(['user_id' => auth()->user()->id, 'status' => LoanRequest::STATUSES['PENDING']])->first();

        if($loanStatus){
            return $this->badRequestResponse('You already have a pending loan request.');
        }

       $response = (new LoanRequestAction())->execute($request);

       return $this->okResponse("Your loan request is been processed",$response);
    }
}