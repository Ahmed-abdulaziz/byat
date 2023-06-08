<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category_item_inputs extends Model
{
        protected $guarded=[];
        
        
         public function getTitleAttribute(){
         if (app()->getLocale()=='ar'){
             return $this->title_ar;
         }elseif (app()->getLocale()=='en'){
             return $this->title_en;
         }else{
             return $this->title_en;
         }
          
    }
    
    
       public function getPlaceholderAttribute(){
         if (app()->getLocale()=='ar'){
             return $this->placeholder_ar;
         }elseif (app()->getLocale()=='en'){
             return $this->placeholder_en;
         }else{
             return $this->placeholder_en;
         }
          
    }
    
    
         public function getUnitAttribute(){
             
             if (app()->getLocale()=='ar'){
                 return $this->unit_ar;
             }elseif (app()->getLocale()=='en'){
                 return $this->unit_en;
             }else{
                 return $this->unit_en;
             }
          
        }
        
        
       
    
    
}
