<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\category_item_components;
class category_item_components extends Model
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
        
         public function item(){
             return $this->belongsTo(category_item_components::class ,'id','category_item_id');
        }
}
