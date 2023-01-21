<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FacilitesController extends Controller
{
    public function show()
    {
        $data = Facilities::all();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
 
    public function create(Request $request)
    {
        $data = Facilities::create([
            'kost_id' => $request->kost_id,
            'bantal' => $request->bantal,
            'guling' => $request->guling,
            'kasur' => $request->kasur,
            'kamar_mandi' => $request->kamar_mandi,
            'laundry' => $request->laundry,
            'dapur' => $request->dapur,
            'kulkas' => $request->kulkas,
            'catering' => $request->catering,
            'wifi' => $request->wifi,
            'tv' => $request->tv,
            'lemari' => $request->lemari,
            'meja' => $request->meja,
            'kursi' => $request->kursi,
            'ac' => $request->ac,
            'kipas' => $request->kipas,
            'jendela' => $request->jendela
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    

}
