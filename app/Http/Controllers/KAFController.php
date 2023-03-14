<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use App\Models\KostandFacilities;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KAFController extends Controller
{
    public function create(Request $request)
    {
        $kost_id = $request->kost_id;
        foreach($request->facilities_id as $key => $value) {
            $data = KostandFacilities::create([
                'kost_id' => $kost_id,
                'facilities_id' => $value
            ]);
            $all[] = $data;
        }

        return response()->json([
            'message' => 'success',
            'data' => $all
        ]);
    }


    public function showByKost($kost_id){
        $data = KostandFacilities::where('kost_id', $kost_id)->get();
        foreach($data->pluck('facilities_id') as $val){
            $fal [] = Facilities::where('id', $val)->get();
        }
        return response()->json([
            'message' => 'success',
            'data' => $fal
        ]);
    }
}
