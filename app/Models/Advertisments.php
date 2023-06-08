<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Malhal\Geographical\Geographical;

class Advertisments extends Model
{
    protected $guarded=[];
    use Geographical;
    const LATITUDE  = 'lat';
    const LONGITUDE = 'long';


    public function users(){
        return $this->belongsToMany(appUsers::class,'favoritesadvs','adv_id','user_id');
    }

    public function owner(){
        return $this->belongsTo(appUsers::class,'user_id');
    }
}
