<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Reason;
use App\Models\Comments;
use App\Models\DetailKost;
use App\Models\KostImages;
use Illuminate\Http\Request;
use App\Models\KostandFacilities;
use Illuminate\Routing\Controller;

class KostController extends Controller
{
    public function show()
    {
        $data = Kost::all();
        return response()->json([
            'message' => 'success retrieved',
            'data' => $data
        ]);
    }


    public function getDetail($id)
    {
        $data = Kost::where('id', $id)->with('user')->first();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function getDetailAcc()
    {
        $data = Kost::where('acc_status', '=', 'accepted')
        ->orWhere('acc_status', '=', 'rejected')->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function getPending()
    {
        $data = Kost::where('acc_status', '=', 'pending')->get();
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
            'cover_img' => 'https://www.kostkostan.my.id/storage/image/kost.jpg',
            'location' => $request->location,
            'location_url' => $request->location_url,
            'kost_type' => $request->kost_type,
            'total_unit' => $request->total_unit,
            'rating' => $request->rating,
            'desc' => $request->desc,
            'width' => $request->width,
            'weight' => $request->weight,
            'payment_period' => $request->payment_period,
            'room_price' => $room_price,
            'elec_price' => $elec_price,
            'total_price' => $room_price + $elec_price
        ]);
    
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
        
    }
    
    public function addCoverImage($kostId){
        $img = KostImages::where('img_type', '=', 'cover_img')->where('kost_id', $kostId)->pluck('img')->first();
        return Kost::where('id', $kostId)->update([
            'cover_img' => $img
        ]);
    }

    

    public function updateStatusAcc($id){
        $data = Kost::where('id', $id);
        $data->update([
            'acc_status' => 'accepted'
        ]);

        $data2 = DetailKost::where('id', $id);
        $data2->update([
            'status' => 'accepted'
        ]);



        response()->json([
            'message' => 'Kost Accepted'
        ]);
    }

    public function updateStatusRej(Request $request){
        $ids = $request->kost_id;
        $data = Kost::where('id', $ids);
        $data->update([
            'acc_status' => 'rejected'
        ]);
        $data2 = DetailKost::where('id', $ids);
        $data2->update([
            'status' => 'rejected'
        ]);

        $data3 = Reason::create([
            'detail_id' => $request->detail_id,
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
        $data = Kost::where('id', $id);
        $data2 = DetailKost::where('id', $id);
        $data3 = KostandFacilities::where('kost_id', $id);
        $data3->delete();
        $data2->delete();
        $data->delete();
        return response()->json([
            'message' => 'data deleted successfully'
        ]);
    }


    public function findPopularKost($location){
        $data = Kost::where('location', 'like', '%' . $location . '%')->where('rating', '>=', 4)->where('acc_status', '=', 'accepted')->latest()->get();
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
        $data = Kost::where('location', 'like', '%' . $location . '%')->where('acc_status', '=', 'accepted')->get();
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
