<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ['name', 'email', 'monthly_payment','user_id'];

    public static $rules = [
        'api_token' => 'required',
        'name' => 'required|min:3',
        'email' => 'required|email',
        'monthly_payment' => 'required|numeric'
    ];
}
