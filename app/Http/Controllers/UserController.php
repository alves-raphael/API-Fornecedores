<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request){
        $request->validate(User::$rules);
        $user = User::create($request->all());
        $user->save();
        return response()->json(['status' => 'Created', 'api_token' => $user->api_token])->setStatusCode(201);
    }

    public function refreshToken(Request $request){
        $request->validate(['email' => 'required', 'password' => 'required']);
        $inputs = $request->all();
        if(Auth::attempt($inputs)){
            $user = User::where(['email' => $inputs['email'], 'senha' => $inputs['password']]);
            return response()->json(['api_token' => $user->api_token])->setStatusCode(200);
        } else {
            return response()->json(['msg' => 'Unable to login'])->setStatusCode(401);
        }
    }

}