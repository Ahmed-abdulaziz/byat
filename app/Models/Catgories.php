<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Catgories extends Model
{
      use SoftDeletes;
    protected $guarded=[];


    public function parent(){
        return $this->belongsTo(Catgories::class,'parent_id');
    }

    public function child(){
        return $this->hasMany(Catgories::class,'parent_id');
    }
    
    
    public function getNameAttribute(){
                 if (app()->getLocale()=='ar'){
                     return $this->name_ar;
                 }elseif (app()->getLocale()=='en'){
                     return $this->name_en;
                 }else{
                     return $this->name_en;
                 }
                  
            }
}
