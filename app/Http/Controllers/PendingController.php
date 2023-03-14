<?php

namespace App\Http\Controllers;

use App\Models\DetailKost;
use App\Models\PendingPayments;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PendingController extends Controller
{
    public function create(Request $request){
        
        $data = PendingPayments::create([
            'user_id' => $request->user_id,
            'detail_id' => $request->detail_id,
            'username' => $request->username,
            'amount' => $request->amount
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function delete($id){
        $data = PendingPayments::find($id);
        $data->delete();

        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }


}
