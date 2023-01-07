<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function show(Request $request){
        $data = User::all();
        return ApiFormatter::createApi(200, 'success', $data);
        
}

public function store(Request $request){
            try {
            $request->validate([
                    'name' => 'required',
                    'email' => 'required|email:dns|unique:users,email',
                    'password' => 'required'
                ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $data = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('Token-Login')->plainTextToken;
                return response()->json([
                    'message' => 'register success',
                    'data' => $data,
                    'token' => $token
                 ]);
            

        
    
        } catch(Exception $e){
            return ApiFormatter::createApi(400, 'data is lacking');
        }
    
}

public function find($id){
        $data = User::find($id);
    if($data){
        return ApiFormatter::createApi(200, 'success', $data);
    } else {
        return ApiFormatter::createApi(400, 'no data');
    }
    
}

public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email:dns',
            ]);

        $data = User::findOrFail($id);

        $data->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $dataW = User::where('id', '=', $data->id)->get();

        return response()->json([
            'message' => 'update success',
            'data' => $dataW,
         ]);
        } catch(Exception $e){


        }
     
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|max:200',
            'password' => 'required',
        ]);

        if (
            !Auth::attempt(
                $request->only('email', 'password')
            )
        ) {
            return response()
                ->json(['message' => 'Try to check email and password'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('Token-Login')->plainTextToken;

        return response()->json([
            'message' => 'login success',
            'data' => $user,
            'token' => $token
         ]);
    }

}
