<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymnet extends Model
{
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(appUsers::class,'user_id');
    }
}
