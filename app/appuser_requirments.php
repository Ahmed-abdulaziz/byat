<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class appuser_requirments extends Model
{
     protected $fillable =['user_id','requirment','change','status','type'];
}
