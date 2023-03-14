<?php

namespace App\Http\Controllers;

use App\Models\KostImages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    
   

    public function create(Request $request){
        $kostId = $request->kost_id;
        $request->validate([
            'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $name_path = 'img' . time() . $request->file('img')->getClientOriginalExtension();
        $request->file('img')->storeAs('image/', $name_path, 'public');
        KostImages::create([
                'kost_id' => $kostId,
                'img' => 'https://www.kostkostan.my.id/storage/image/' . $name_path,
                'img_type' => 'detail_img'
            ]);
        return response()->json([
            'message' => 'upload success'
        ]);
    }

    public function createCover(Request $request){
        $kostId = $request->kost_id;
        $request->validate([
            'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $name_path = 'img' . time() . $request->file('img')->getClientOriginalExtension();
        $request->file('img')->storeAs('image/', $name_path, 'public');
        KostImages::create([
                'kost_id' => $kostId,
                'img' => 'https://www.kostkostan.my.id/storage/image/' . $name_path,
                'img_type' => 'cover_img'
            ]);
        return response()->json([
            'message' => 'upload success'
        ]);
    }

  
    public function getImageByKost($kostId)
    {
        $data = KostImages::where('img_type', '=', 'detail_img')->where('kost_id', $kostId)->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

  
}
