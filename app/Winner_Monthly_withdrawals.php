<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Models\appUsers;
class Winner_Monthly_withdrawals extends Model
{
     protected $guarded=[];
     
        
        public function user(){
        return $this->belongsTo(appUsers::class);
    }
}
