<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $guarded=[];
    public function area(){
        return $this->hasMany(area::class,'city_id');
    }
}
