<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\LoanRequest;
use Illuminate\Console\Command;

class LoanPercentIncrease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:percentage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase the percentage of borrowed amount by 3% daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $loanRequests = LoanRequest::where('status', '=', 'approved_by_admin')->get();

        foreach ($loanRequests as $loanRequest) {
            $diff = Carbon::parse(Carbon::now())->diffInHours(Carbon::parse($loanRequest->updated_at));

            if ($diff >= 24) {
                $increment = (3/100) * $loanRequest->amount_to_be_paid;
                $loanRequest->amount_to_be_paid = $loanRequest->amount_to_be_paid + $increment;
                $loanRequest->save();
            }

            if (Carbon::now()->diffInDays($loanRequest->approved_at) >= 14) {
                $this->sendReminderEmail($loanRequest);
            }
        }
    }

    // private function sendReminderEmail($loanRequest)
    // {
    //     $user = $loanRequest->user;
    //     $user->notify(new \App\Notifications\LoanReminder($loanRequest));
    //    // send notification to admin
    //     $admin = \App\Models\User::where('role_id', '=', 2)->first();
    //     $admin->notify(new \App\Notifications\LoanReminder($loanRequest));
    // }
}
