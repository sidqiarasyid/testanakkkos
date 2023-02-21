<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\KostChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChatRoomController extends Controller
{
    public function create(Request $request){
        $kost_id = $request->kost_id;
        $userid = $request->user_id;
        $seller_id = Kost::where('id', $kost_id)->pluck('seller_id')->first();
        $kostname = Kost::where('id', $kost_id)->pluck('kost_name')->first();
        $username = User::where('id', $userid)->pluck('name')->first();
        $sellername = User::where('id', $seller_id)->pluck('name')->first();
        $data = KostChat::create([
                'kost_id' => $kost_id,
                'seller_id' => $seller_id,
                'seller_name' => $sellername,
                'user_id' => $userid,
                'username' => $username,
                'kost_name' => $kostname,
            ]);


        return response()->json([
            'message' => 'chat room created',
            'data' => $data,
        ]);
    }

    public function getRoomChatforUser($userId){
        $kost_chats = KostChat::where('user_id', $userId)->get();
        return response()->json([
            'message' => 'retrieve chat success',
            'data' => $kost_chats
        ]);
    }

    public function getRoomChatforSeller($sellerId){
        $kost_chats = KostChat::where('seller_id', $sellerId)->get();
        return response()->json([
            'message' => 'retrieve chat success',
            'data' => $kost_chats
        ]);
    }

    public function getMessage($chatId){
        $kost_chats = KostChat::where('id', $chatId)->with('message')->first();
        return response()->json([
            'message' => 'retrieve chat success',
            'data' => $kost_chats
        ]);
    }




    
    public function getAll(){
        return KostChat::all();
    }
}
