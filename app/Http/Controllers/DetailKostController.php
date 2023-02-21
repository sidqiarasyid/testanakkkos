<?php

namespace App\Http\Controllers;

use App\Models\DetailKost;
use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DetailKostController extends Controller
{
    //

    public function create(Request $request){
        $kostId = $request->kost_id;
        $kostName = Kost::where('id', $kostId)->pluck('kost_name')->first();
        $kostLocation = Kost::where('id', $kostId)->pluck('location')->first();
        $unit_open = Kost::where('id', $kostId)->pluck('total_unit')->first();
        $data = DetailKost::create([
            'seller_id' => $request->seller_id,
            'kost_id' => $kostId,
            'profit' => 0,
            'avg_rating' => 0,
            'unit_rented' => 0,
            'unit_open' => $unit_open,
            'kost_name' => $kostName,
            'status' => 'pending',
            'kost_img' => 'kosong',
            'kost_location' => $kostLocation
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

  

    public function getByKost($kostId){
        $data = DetailKost::where('kost_id', $kostId)->with('pending')->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function getKostBySeller($user_id){
        $kost = DetailKost::where('seller_id', $user_id)->get();
        if($kost == null){
            return response()->json(['message' => 'gavin']);
        } else {
            return response()->json([
                'message' => 'success',
                'data' => $kost
            ]);
        }
        
    }



    public function updateStat(Request $request, $id){
        $data = DetailKost::find($id);
        $data->update([
            'profit' => $request->profit,
            'avg_rating' => $request->avg_rating,
            'unit_rented' => $request->unit_rented
        ]);

        return response()->json([
            'message' => 'update success',
            'data' => $data
        ]);
    }

    
}
