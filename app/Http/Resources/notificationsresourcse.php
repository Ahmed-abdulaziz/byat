<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\auction_users;
use App\Auctions;
use Carbon\Carbon;
class notificationsresourcse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        
                    $auction = Auctions::find($this->product_id);
                    if($auction){
                            $this->owner = $auction->owner_id;
                            $this->price=auction_users::where('auction_id' , $this->product_id)->orderBy('id',"DESC")->limit('1')->value("price");
                    }

            
        return [
                        'id'                                => $this->id,
                        'msg'                               => $this->msg ,
                        'title'                             => $this->title  ? $this->title  : '',
                        'product_id'                        => $this->product_id ? $this->product_id : 0,
                        'user_id'                           => $this->user_id  ? $this->user_id  : 0,
                        'owner_id'                          => $auction ? $auction->owner_id   : 0,
                        'type'                              => $this->type  ,
                        'code'                              => $this->code ? $this->code : '',
                        'readed'                            => $this->readed  ,
                        'created_at'                        => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')  ,
                        'updated_at '                       => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')  ,
                        'created'                           => strtotime($this->created_at),
            ];
    }
}
