<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RatingController extends Controller
{
  

    public function updateRating($kostId){
        $data = Rating::where('kost_id', $kostId)->get();
        $average = $data->avg('rating');
        Kost::where('id', $kostId)->update([
            'rating' => $average
        ]);
        return response()->json([
            'message' => $average
        ]);
    }
}
