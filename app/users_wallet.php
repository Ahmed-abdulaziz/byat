<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_wallet extends Model
{
     protected $fillable =['user_id','auction_id','money','comment','code','amount'];
}
