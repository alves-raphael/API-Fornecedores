<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\User;

class ProviderController extends Controller
{
    public function create(Request $request){
        $request->validate(Provider::$rules);
        $provider = new Provider($request->except('api_token'));
        $request->user()->providers()->save($provider);
        return response()->json(['status' => 'Created'])->setStatusCode(201);
    }

    public function get(Request $request){
        return $request->user()->providers()->get();
    }
}
