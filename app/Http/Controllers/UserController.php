<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function create(Request $request){
        $user = new User($request->all());
        $user->save();
        return response()->json(['status' => 'Created'])->setStatusCode(201);
    }

    public function getAll(){
        return User::all();
    }
}
