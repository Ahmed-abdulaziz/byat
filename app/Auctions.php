<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\appUsers;
use App\AuctionImages ;
use Illuminate\Database\Eloquent\SoftDeletes;
class Auctions extends Model
{
      use SoftDeletes;
     protected $guarded=[];
     
      public function user(){
        return $this->belongsTo(appUsers::class,'user_id');
    }
    
     public function images(){
        return $this->hasMany(AuctionImages::class,'auction_id');
    }
}
