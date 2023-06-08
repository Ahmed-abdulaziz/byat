<?php

namespace App\Http\Resources;
use App\Auctions;
use App\Advertisments;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\area;
use App\Models\appUsers;
use App\Models\Catgories;
use Carbon\Carbon;
use App\auction_users;
use App\depoist_payment_users;
use App\Traits\GeneralTrait;
use App\Http\Resources\singleAuctionResources;
use App\favorites;
use App\category_items;
use App\category_item_components;
use App\category_item_products;
use App\Http\Resources\ProductfiltersResource;
class AuctionResources extends JsonResource
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
            
            
    
       //   ------------------------------Check Expired Auctions-----------------------------------------------
                            // $nowDate = Carbon::now();
                            // $check_date_of_auction = $nowDate->gt($this->end_date);
                            // $check_count = auction_users::where('auction_id',$this->id)->count();
                            //  if($check_date_of_auction && $this->status == 1){
                            //         if($check_count > 0){
                            //             $last_user = auction_users::latest()->first();
                            //               $allpayment = depoist_payment_users::where('auction_id',$this->id)->where('user_id','!=',$last_user->user_id)->get();
                            //                 foreach($allpayment as $payment){
                            //                       $resource=$this->back_users_deposit($payment);
                            //                       $payment->update([
                            //                             'status'=> 1,
                            //                         ]);
                            //                 }
                            //                  $this->update([
                            //                     'status'=> 2,
                            //                     'owner_id'=>$last_user->user_id,
                            //                 ]);
                                
                            //                   $this->status = 2;
                            //         }else{
                                 
                            //          $this->update([
                            //             'status'=> 3,
                            //         ]);
                                
                            //              $this->status = 3;
                            //         }
                            //  }
             
                    //------------------------------------------------------------------------------------------------- 
                    
                 $favorites =  favorites::where('user_id', $id)->where('product_id', $this->id)->where('type', 1)->first();
                
                 $imageData = [];
                  foreach( $this->images as $image){
                      $imageData[] = asset('uploads/auctions/'.$image->img);
                  }
             
             
                $similar_auction = Auctions::where('cat_id',$this->cat_id)->get();
                
                $similar_auction=singleAuctionResources::collection($similar_auction);


                $Auct = Auctions::find($this->id);
                $Auct->update(['views'=> $this->views + 1 ]);
                    
                
                $filters = category_item_products::where('product_id',$this->id)->where('type',1)->get();
                $resource=ProductfiltersResource::collection($filters);
                
                

                 $this->place = area::find($this->place_id);
                 
                 if($this->place){
                     $this->place = $this->place->name;
                 }else{
                     $this->place = 'Not Found Area';
                 }
                 
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
                     $this->cat = 'Not Found Category';
                 }
                 
                 
                $user = appUsers::find($this->user_id);
        
                $this->imgs = $imageData;
                if($this->end_date == NULL){
                    $this->end_date ='';
                }
            
                $check_count = auction_users::where('auction_id',$this->id)->count();
                if($check_count > 0){
                      $this->latest_user_price = auction_users::where('auction_id' ,$this->id )->latest()->first()->price;
                  }else{
                      $this->latest_user_price = 0;
                  }
                 
                 $owner = appUsers::find($this->owner_id);
                                
    return[
           "id"                                         =>$this->id,
            "user_id"                                   =>$this->user_id,
            "name"                                      =>$this->name,
             "amount_open"                              =>$this->amount_open,
            "description"                               =>$this->description,
            "maximum_amount"                            =>$this->maximum_amount,
            "deposit_amount"                            =>$this->deposit_amount,
            "day"                                       =>$this->day,
            "hours"                                     =>$this->hours,
            "end_date"                                  =>$this->end_date,
            "owner_id"                                  =>$owner ? $owner->id : 0,
            "show_status"                               =>$this->show_status,
            "user"                                      =>$user ? $user->name : '',
            "user_phone"                                =>$user ? $user->phone : '',
            "user_date"                                 =>$user ?  Carbon::parse($user->created_at)->format('Y') : '',
            "status"                                    =>$this->status,
            "created_at"                                =>Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            "updated_at"                                =>Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            "place"                                     =>$this->place ? $this->place : '',
            "cat"                                       =>$cat ? $cat->name : '',
            "main_cat"                                  =>$this->parent_name ? $this->parent_name : '' ,
            'views'                                     =>$this->views,
            'favorite'                                  => $favorites ? 1 : 0,
            "owner"                                     =>$owner ? $owner->name : '',
            'show_last_bid'                             =>$this->show_last_bid,
            'examination_certificate'                   =>$this->examination_certificate ? asset('uploads/auctionsexamination_certificate/'.$this->examination_certificate) : '',
            "imgs"                                      =>$imageData,
            'latest_user_price'                         =>$this->latest_user_price,
            'count_user_auctions'                       =>$check_count,
            'repost'                                    =>$this->repost,
            'filters'                                   =>$resource,
            'similar_auction'                           =>$similar_auction ? $similar_auction : ''
        ];

     
    }
}
