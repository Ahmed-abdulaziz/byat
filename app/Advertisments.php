<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\appUsers;
use App\Models\Advimages;
use Illuminate\Database\Eloquent\SoftDeletes;
class Advertisments extends Model
{
      use SoftDeletes;
      protected $guarded=[];
      protected $orderDirection = 'DESC';

      public function user(){
        return $this->belongsTo(appUsers::class,'user_id');
    }
    
     public function images(){
        return $this->hasMany(Advimages::class,'adv_id');
    }
}
