<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\category_item_components;
use App\category_item_inputs;
class category_items extends Model
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
    
        public function components(){
        return $this->hasMany(category_item_components::class , 'category_item_id' ,'id');
        }
        
        
         public function components_inputs(){
            return $this->hasMany(category_item_inputs::class , 'category_item_id' ,'id');
        }
        
}
