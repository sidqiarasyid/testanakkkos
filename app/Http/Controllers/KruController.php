<?php

namespace App\Http\Controllers;

use App\Models\KostRules;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KruController extends Controller
{
    public function create(Request $request)
    {
        $kost_id = $request->kost_id;
        foreach($request->content as $value) {
            $data = KostRules::create([
                'kost_id' => $kost_id,
                'content' => $value
            ]);
            $all[] = $data;
        }

        return response()->json([
            'message' => 'success',
            'data' => $all
        ]);
    }

    public function getRules($kostId){
        $data = KostRules::where('kost_id', $kostId)->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
}
