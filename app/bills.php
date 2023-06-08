<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Models\appUsers;
class bills extends Model
{
       protected $guarded=[];

        public function getNameAttribute(){
             if (app()->getLocale()=='ar'){
                 return $this->name_ar;
             }elseif (app()->getLocale()=='en'){
                 return $this->name_en;
             }else{
                 return $this->name_en;
             }
              
        }
        
        
        
        public function user(){
        return $this->belongsTo(appUsers::class);
    }
}
