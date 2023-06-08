<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Auctions;
use App\Advertisments;
use App\bills;
use App\Winner_Monthly_withdrawals;
class appUsers extends Authenticatable implements JWTSubject
{

    protected $guarded=[];

    protected $hidden=[
        'password'
    ];


    public function favadv(){
        return $this->belongsToMany(Advertisments::class,'favoritesadvs','user_id','adv_id')->where('status','=',1);
    }

    public function payment_request(){
        return $this->hasMany(UserPaymnet::class,'user_id');
    }

    public function advertiemsts(){
        return $this->hasMany(Advertisments::class,'user_id');
    }
    
     public function auctions(){
        return $this->hasMany(Auctions::class,'user_id');
    }

    public function getID()
    {
        $id='#45d9f3b'.$this->id;
        return (string)$id;
    }


    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
     public function bills()
    {
        return $this->hasMany(bills::class);
    }
     public function Winner_Monthly_withdrawals()
    {
        return $this->hasMany(Winner_Monthly_withdrawals::class);
    }

}
