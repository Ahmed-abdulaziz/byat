<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class area extends Model
{
    protected $guarded=[];
    public function city(){
        return $this->belongsTo(city::class,'city_id');
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
