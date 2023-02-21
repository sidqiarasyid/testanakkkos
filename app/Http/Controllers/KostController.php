<?php

namespace App\Http\Controllers;

use App\Models\DetailKost;
use App\Models\Kost;
use App\Models\Comments;
use App\Models\KostandFacilities;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KostController extends Controller
{
    public function show()
    {
        $data = Kost::with('user')->get();
        return response()->json([
            'message' => 'success retrieved',
            'data' => $data
        ]);
    }


    public function getDetail($id)
    {
        $data = Kost::find($id)->with('user')->first();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
    

    public function create(Request $request)
    {
        $room_price = $request->room_price;
        $elec_price = $request->elec_price;
        
        $data = Kost::create([
            'acc_status' => 'pending',
            'seller_id' => $request->seller_id,
            'unit_open' => $request->total_unit,
            'kost_name' => $request->kost_name,
            'location' => $request->location,
            'location_url' => $request->location_url,
            'kost_type' => $request->kost_type,
            'total_unit' => $request->total_unit,
            'rating' => $request->rating,
            'desc' => $request->desc,
            'width' => $request->width,
            'weight' => $request->weight,
            'payment_period' => $request->payment_period,
            'room_rules' => $request->room_rules,
            'kost_rules' => $request->kost_rules,
            'room_price' => $room_price,
            'elec_price' => $elec_price,
            'total_price' => $room_price + $elec_price
        ]);
    
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
        
    }

    public function updateStatusAcc($id){
        $data = Kost::firstOrFail($id);
        $data->update([
            'acc_status' => 'accepted'
        ]);

        $data2 = DetailKost::firstOrFail($id);
        $data2->update([
            'status' => 'accepted'
        ]);



        response()->json([
            'message' => 'Kost Accepted'
        ]);
    }

    public function updateStatusRej(Request $request){
        $ids = $request->kost_id;
        $data = Kost::firstOrFail($ids);
        $data->update([
            'acc_status' => 'rejected'
        ]);
        $data2 = DetailKost::firstOrFail($ids);
        $data2->update([
            'status' => 'rejected'
        ]);

        $data3 = Reason::create([
            'detail_id' => $request->user_id,
            'reason' => $request->reason,
        ]);
        return response()->json([
            'message' => 'kost rejected',
            'data' => $data3
        ]);

    
    }
    

    public function update(Request $request, $id)
    {
        $data = Kost::findOrFail($id);
        $room_price = $request->room_price;
        $elec_price = $request->elec_price;
        $data->update([
            'kost_name' => $request->kost_name,
            'room_price' => $room_price,
            'elec_price' => $elec_price,
            'desc' => $request->desc,
            'total_price' => $room_price + $elec_price
        ]);

        $dataW = Kost::where('id', '=', $data->id)->get();

        return response()->json([
            'update success',
            'data' => $dataW
        ]);
    }

    

    public function delete($id){
        $data = Kost::find('id', $id);
        return $data;
    }


    public function findPopularKost($location){
        $data = Kost::where('location', 'like', '%' . $location . '%')->where('rating', '>=', 4)->latest()->get();
        if($data == null){
            return response()->json([
                'message' => 'data not found',
            ]);
        } else{
            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        }
    }
    
    public function findNearestKost($location){
        $data = Kost::where('location', 'like', '%' . $location . '%')->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

   

    public function filterKostByFacilities(Request $request){
        foreach($request->data as $key => $value) {
            $dataId = KostandFacilities::where('facilities_id', $value)->pluck('kost_id');
        }

        $listKost = [];
        foreach($dataId as $keyy => $val2){        
            $kost = Kost::where('id', $val2)->get();
            array_push($listKost, $kost);
        }
        
        
        // return $request->all();
        return response()->json([
            "data" => $listKost,
        ]   );
    }
    
}
