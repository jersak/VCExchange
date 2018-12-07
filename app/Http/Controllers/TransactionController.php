<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\User;

use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function createTransaction(Request $request)
    {
        $messages = [
            'different'    => 'You must send VC to someone else.',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'from'      => 'required|email|exists:users,email',
                'to'        => 'required|email|different:from|exists:users,email',
                'amount'    => 'required|numeric|min:0.01',
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        $from = User::where('email', $request->from)->first();
        $to = User::where('email', $request->to)->first();

        // Check if sender has enough VC
        if ($request->amount > $from->virtual_currency) {
            return response()->json(['amount' => ['You don\'t have enough VC to complete this transaction.']], 422);
        }

        try {
            // Start DB transaction to ensure the transfer is executed atomically
            DB::beginTransaction();

            $from->virtual_currency -= $request->amount;
            $from->save();

            $to->virtual_currency += $request->amount;
            $to->save();

            $transaction = new Transaction;
            $transaction->from_user = $from->id;
            $transaction->to_user = $to->id;
            $transaction->amount = $request->amount;

            if (isset($request->note)) {
                $transaction->note = $request->note;
            }

            $transaction->save();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array("errorCode" => $e->getCode(), "errorMessage" => $e->getMessage()), 500);
        }

        DB::commit();

        return response()->json($transaction, 200);
    }

    public function createBulkTransactions(Request $request)
    {
        $messages = [
            'different'    => 'You must send VC to someone else.',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'from'      => 'required|email|exists:users,email',
                'to'        => 'required',
                'to.*'      => 'required|email|different:from|exists:users,email',
                'amount'    => 'required',
                'amount.*'  => 'required|numeric|min:0.01',
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        dd($request->all());
    }

    public function getUserTransactions($user_id)
    {
        $transactions = Transaction::where('from_user', $user_id)
                        ->orWhere('to_user', $user_id)
                        ->get();

        return $transactions;
    }
}
