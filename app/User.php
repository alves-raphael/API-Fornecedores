<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'cep', 'phone', 'address', 'cnpj', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'email' => 'required|min:3|email|unique:users',
        'password' => 'required|min:3',
        'cnpj' => 'required|min:14',
        'cep' => 'required|min:8'
    ];

    protected function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['api_token'] = Str::random(60);
        return parent::create($data);
    }

    public function providers(){
        return $this->hasMany('App\Provider');
    }
}
