<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    public function create(Request $request){
        $user_id = $request->user_id;
        $username = User::where('id', $user_id)->pluck('name')->first();
        $msg = Message::create([
            'kost_chat_id' => $request->kost_chat_id,
            'user_id' => $user_id,
            'username' => $username,
            'role' => $request->role,
            'msg_content' => $request->msg_content,
        ]);

        return response()->json([
            'message' => 'message sent',
            'data' => $msg
        ]);
    }

    
}
