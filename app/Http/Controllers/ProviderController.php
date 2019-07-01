<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\User;
use Illuminate\Cache\Repository;

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

    public function destroy(Request $request){
        $request->validate(['id' => 'required|numeric']);
        $provider = Provider::find($request['id']);
        if(!$provider) return response()->json(['status' => 'Provider not found with the given id'])->setStatusCode(404);
        $provider->delete();
        return response()->json(['status' => 'Deleted'])->setStatusCode(200);
    }
    
    public function update(Request $request){
        $request->validate(['id' => 'required']);
        $provider = Provider::find($request['id']);
        if(!$provider) return response()->json(['status' => 'Provider not found with the given id'])->setStatusCode(404);
        $provider->set($request->except('api_token'));
        $provider->save();
        return response()->json(['status' => 'Updated'])->setStatusCode(200);
        
    }

    public function totalPayment(Request $request){
        $id = $request->user()->id;
        return response()->json([Provider::where('user_id', $id)->pluck('monthly_payment')->sum()]);
    }
}
