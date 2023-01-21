<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionsController extends Controller
{
    public function create(Request $request)
    {
        $data = Transactions::create([
            'kost_id' => $request->kost_id,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'proof_img' => $request->proof_img,
            'stay_duration' => $request->stay_duration,
            'transaction_id' => $request->transaction_id
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function getTransactionById($tranc_id)
    {
        $find = Transactions::where('transaction_id', $tranc_id)->with('kost')->get();
        return response()->json([
            'message' => 'success',
            'data' => $find
        ]);

    }
}
