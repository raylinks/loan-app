<?php

namespace App\Http\Actions;

use Exception;
use App\Models\Bank;
use App\Models\User;
use App\Http\Clients\Flutterwave;
use Illuminate\Support\Facades\DB;

class SettingsAction
{
    public function execute($request)
    {
        DB::beginTransaction();
        try {

        $requestData = $request->only(['account_number', 'bank_code']);

        $result = (new Flutterwave())->getAccountName($requestData);

        $bank = Bank::where('code', $request->bank_code)->first();

        $user = User::where('id', auth()->user()->id)->first();

        $result = $user->bankAccount()->create([
            'account_number' => $request->account_number,
            'account_name' => data_get($result, 'data.account_name'),
            'bank_id' => $bank->id,
            'bank_name' => $bank->name
        ]);

        DB::commit();

        return $result;

    } catch (Exception $exception) {
        DB::rollBack();
        abort(503, "Service is unavailable to process loan request");
    }

    }
}
