<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReasonController extends Controller
{
    public function create(Request $request){
        
        $data = Reason::create([
            'detail_id' => $request->user_id,
            'reason' => $request->detail_id,
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function getReasonbyDetail($id){
        $data = Reason::where('detail_id', $id)->first;
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
}
