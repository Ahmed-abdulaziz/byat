<?php

namespace App\Http\Resources\Advertimnets;
use App\Auctions;
use App\Advertisments;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\area;
use App\Models\appUsers;
use App\Models\Catgories;
use Carbon\Carbon;
use App\category_items;
use App\category_item_components;
use App\category_item_products;
use App\Http\Resources\ProductfiltersResource;
use App\Http\Resources\singleAdvResource;
use App\Traits\GeneralTrait;
use App\favorites;

class usercollection extends JsonResource
{
    use GeneralTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                $id = 0;
            }
            
            
            $favorites =  favorites::where('user_id', $id)->where('product_id', $this->id)->where('type', 0)->first(); 
            $imageData = [];
              foreach( $this->images as $image){
                  $imageData[] = asset('uploads/advimage/'.$image->img);
              }
              
            $this->place = area::find($this->place_id);
             if($this->place){
                 $this->place = $this->place->name;
             }else{
                 $this->place = 'لا يوجد منطقه';
             }
             
             $adv = Advertisments::find($this->id);
             $adv->update(['views'=> $this->views + 1 ]);
             
            $filters = category_item_products::where('product_id',$this->id)->where('type',0)->get();
            $resource=ProductfiltersResource::collection($filters);
            
            
           $similar_ads = Advertisments::where('cat_id',$this->cat_id)->get();
           
           $similar_ads=singleAdvResource::collection($similar_ads);
             
             $cat = Catgories::find($this->cat_id);
             if($cat){
                 $this->cat = $cat->name;
                   $catparent = Catgories::find($cat->parent_id);
                  if($catparent){
                         $this->parent_name = $catparent->name;
                          $this->parent_id = $catparent->id;
                     }else{
                         $this->parent_name = '';
                         $this->parent_id = 0;
                     }
             }else{
                 $this->cat = 'لا يوجد قسم';
             }
            
            if($this->star == 1){
                if($this->end_star < Carbon::now()->format("Y-m-d")){
                    Advertisments::find($this->id)->update(['star'=> 0]);
                }
            }
            
            $user = appUsers::find($this->user_id);
           
                                
    return[
           "id"                         =>$this->id,
            "user_id"                   =>$this->user_id,
            "name"                      =>$this->name,
            "description"               =>$this->description,
            "price"                     =>$this->price,
            "phone"                     =>$this->phone,
            "whatsapp"                  =>$this->whatsapp ? $this->whatsapp : '',
            "place_id"                  =>$this->place_id ? $this->place_id : 0,
            "cat_id"                    =>$this->cat_id ? $this->cat_id : 0,
            "user"                      =>$user ? $user->name : '',
            "user_date"                 =>$user ?  Carbon::parse($user->created_at)->format('Y') : '',
            "star"                      =>$this->star,
            "status"                    =>$this->status,
            'views'                     =>$this->views,
            "created_at"                =>Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            "updated_at"                =>Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            "place"                     =>$this->place ? $this->place : '',
            "cat"                       =>$this->cat ? $this->cat : '',
            "main_cat_id"               =>$this->parent_id,
            "main_cat"                  =>$this->parent_name ? $this->parent_name : '' ,
            'favorite'                  => $favorites ? 1 : 0,
            "imgs"                      =>$imageData,
            'examination_certificate'   =>$this->examination_certificate ? asset('uploads/advexamination_certificate/'.$this->examination_certificate) : '',
            'end_star'                  =>$this->end_star ? $this->end_star : '',
            'filters'                   =>$resource,
            'similar_ads'               =>$similar_ads ? $similar_ads : ''
        ];

     
    }
}
