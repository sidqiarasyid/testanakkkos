<?php

namespace App\Http\Controllers;

use App\Models\DetailKost;
use App\Models\Kost;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionsController extends Controller
{
    public function create(Request $request)
    {
        $kostId = $request->kost_id;
        
        $total_price = Kost::find($kostId)->pluck('total_price')->first();
        $room_price = Kost::find($kostId)->pluck('room_price')->first();
        $elec_price = Kost::find($kostId)->pluck('elec_price')->first();
        $kost_name = Kost::find($kostId)->pluck('kost_name')->first();
        $kost_type = Kost::find($kostId)->pluck('kost_type')->first();
        $location = Kost::find($kostId)->pluck('location')->first();
        $data = Transactions::create([
            'kost_id' => $kostId,
            'user_id' => $request->user_id,
            'kost_name' => $kost_name,
            'kost_type' => $kost_type,
            'location' => $location,
            'status' => $request->status,
            'stay_duration' => $request->stay_duration,
            'total_price' => $total_price,
            'room_price' => $room_price,
            'electricity' => $elec_price,
            'due_date' => $request->due_date,
        ]);



        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }


    public function getByUser($userId)
    {
        $find = Transactions::where('user_id', $userId)->with('kost')->get();
        return response()->json([
            'message' => 'success',
            'data' => $find
        ]);
    }

    public function updateStatus(Request $request){
        $kostId = $request->kost_id;
        $total_price = Kost::find($kostId)->pluck('total_price')->first();
        $data = Transactions::where('id', $request->id);
        $Profit = DetailKost::where('kost_id', $kostId)->pluck('profit')->first();
        $Rented = DetailKost::where('kost_id', $kostId)->pluck('unit_rented')->first();
        $Open = DetailKost::where('kost_id', $kostId)->pluck('unit_open')->first();
        $KostOpen = Kost::where('id', $kostId)->pluck('unit_open')->first();
        $newUnitRented = $Rented + 1;
        $newUnitOpen = $Open - 1;
        $newKostOpen = $KostOpen - 1;
        $newprofit = $total_price + $Profit;
        DetailKost::where('kost_id', $kostId)->update([
            'profit' => $newprofit,
            'unit_rented' => $newUnitRented,
            'unit_open' => $newUnitOpen
        ]);
        Kost::where('id', $kostId)->update([
            'unit_open' => $newKostOpen
        ]);
        $data->update([
            'status' => $request->status,
        ]);
    }

}
