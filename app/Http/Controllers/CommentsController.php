<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Client\Response;

class CommentsController extends Controller
{
    public function get()
    {
        $data = Comments::with('user')->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
       
        $data = Comments::create([
            'kost_id' => $request->kost_id,
            'user_id' => $request->user_id,
            'comment_body' => $request->comment_body,
            'rating' => $request->rating
        ]); 

        Rating::create([
            'kost_id' => $request->kost_id,
            'rating' => $request->rating,
        ]);

        

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function filterByPost($id)
    {
        $comment = Comments::where('kost_id', $id)->with('user')->get();   
        return response()->json([
            'message' => 'success',
            'data' => $comment
        ]);

    }
}
