<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Comments;
use App\Models\KostandFacilities;
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

    public function create(Request $request)
    {
        $data = Kost::create([
            'seller_id' => $request->seller_id,
            'kost_name' => $request->kost_name,
            'location' => $request->location,
            'rating' => $request->rating,
            'total_transaction' => $request->total_transaction,
            'payment_period' => $request->payment_period,
            'rules' => $request->rules,
            'wifi_price' => $request->wifi_price,
            'elec_price' => $request->elec_price,
        ]);

    
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Kost::findOrFail($id);
        $data->update([
            'kost_name' => $request->kost_name,
            'total_transaction' => $request->total_transaction,
            'payment_period' => $request->payment_period,
            'rules' => $request->rules,
            'wifi_price' => $request->wifi_price,
            'elec_price' => $request->elec_price,
        ]);

        $dataW = Kost::where('id', '=', $data->id)->get();

        return response()->json([
            'update success',
            'data' => $dataW
        ]);
    }

    public function getFacilities($id)
    {
        $data = Kost::find($id);
        $facilites = $data->facilities;
        return response()->json([
            'message' => 'success',
            'data' => $facilites
        ]);
    }


    
    
    public function findNearestKost($location){
        $data = Kost::latest();
        $data->where('location', 'like', '%' . $location . '%');
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function filterKostByFacilities(Request $request){

        $kost = [];
        foreach($request->data as $key => $value) {
            $data = KostandFacilities::where('facilities_id', $value)->with('kost');
            // dd($value);
            foreach($data->get() as $a){
                $kost[] = $a;
            }
        }
        
        // return $request->all();
        return response()->json([
            'message' => 'your search result',
            'data' => $kost
        ]);
    }
    
}
