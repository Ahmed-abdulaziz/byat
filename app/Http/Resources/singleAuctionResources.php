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
use App\favorites;
class singleAuctionResources extends JsonResource
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
    
    //   //   ------------------------------Check Expired Auctions-----------------------------------------------
    //                         $nowDate = Carbon::now();
    //                         $check_date_of_auction = $nowDate->gt($this->end_date);
    //                         $check_count = auction_users::where('auction_id',$this->id)->count();
    //                          if($check_date_of_auction && $this->status == 1){
    //                                 if($check_count > 0){
    //                                     $last_user = auction_users::latest()->first();
    //                                       $allpayment = depoist_payment_users::where('auction_id',$this->id)->where('user_id','!=',$last_user->user_id)->get();
    //                                         foreach($allpayment as $payment){
    //                                               $resource=$this->back_users_deposit($payment);
    //                                               $payment->update([
    //                                                     'status'=> 1,
    //                                                 ]);
    //                                         }
    //                                          $this->update([
    //                                             'status'=> 2,
    //                                             'owner_id'=>$last_user->user_id,
    //                                         ]);
                                
    //                                           $this->status = 2;
    //                                 }else{
                                 
    //                                  $this->update([
    //                                     'status'=> 3,
    //                                 ]);
                                
    //                                      $this->status = 3;
    //                                 }
    //                          }
             
             
             $auction_users = auction_users::where('auction_id',$this->id)->count();
            if($auction_users < 1){
                $min_amount = $this->amount_open;
            }else{
                $min = auction_users::where('auction_id',$this->id)->get()->last();
                $min_amount =$min->price;
            }
            
            $favorites =  favorites::where('user_id', $id)->where('product_id', $this->id)->where('type', 1)->first();
                    //------------------------------------------------------------------------------------------------- 
                // return $this->images ;
            $imageData = '';
              foreach( $this->images as $image){
                  $imageData = asset('uploads/auctions/'.$image->img);
                  break;
              }
                                
    return[
          "id"                                          =>$this->id,
            "user_id"                                   =>$this->user_id,
            "name"                                      =>$this->name,
            "amount_open"                               =>$this->amount_open,
            "day"                                       =>$this->day,
            "hours"                                     =>$this->hours,
            'current_price'                             =>$min_amount,
            "end_date"                                  =>$this->end_date ? $this->end_date : '',
            'favorite'                                  =>$favorites ? 1 : 0,
            "image"                                     =>$imageData,
            "status"                                    =>$this->status,
        ];

     
    }
}
