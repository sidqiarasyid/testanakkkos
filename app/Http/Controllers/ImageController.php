<?php

namespace App\Http\Controllers;

use App\Models\KostImages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImageController extends Controller
{
    
   

    public function create(Request $request){
        $kostId = $request->kost_id;
        $request->validate([
            'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = $request->file('img')->store('image', 'public');
        KostImages::create([
                'kost_id' => $kostId,
                'img' => $image_path
            ]);
        return response()->json([
            'message' => 'upload success'
        ]);
    }



    public function getImageByKost($kostId)
    {
        $data = KostImages::where('kost_id', $kostId);
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
  
}
