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
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    

}
