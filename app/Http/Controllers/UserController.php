<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);   
        $user->save();

        $token = $user->createToken('myToken')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=>$token
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        
        return response()->json([
            'message'=>'Tokens Deleted Successfully',
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message'=>'Credentials Incorrect'
            ], 401);
        }
        $token = $user->createToken('mytoken')->plainTextToken;
        
        return response([
            'user'=>$user,
            'token'=>$token
        ], 200);
    }
}
