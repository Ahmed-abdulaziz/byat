<?php

namespace App\Http\Resources;
use App\Auctions;
use App\Advertisments;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\singleAdvResource;
use App\Http\Resources\singleAuctionResources;
use Carbon\Carbon;

class profileclientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        
        $user_count_advertisments = Advertisments::withTrashed()->where('user_id',$this->id)->count();
       

        $user_count_auctions= Auctions::where('user_id',$this->id)->count();
          
        
        $auctions= Auctions::where('user_id',$this->id)->count();
        $advertisments = Advertisments::withTrashed()->where('user_id',$this->id)->get();
        $resource_advertisments=singleAdvResource::collection($advertisments);
        
        
        $auctions = Auctions::withTrashed()->where('user_id',$this->id)->get();
        $resource_auctions=singleAuctionResources::collection($auctions);
        
        
        return [
                'id'                        => $this->id,
                'name'                      => $this->name,
                'email'                     => $this->email ? $this->email : '',
                'phone'                     => $this->phone ? $this->phone : '',
                'image'                     => asset('uploads/user_images/'.$this->img),
                'api_token'                 => $this->api_token,
                'adv_numbers'               => $user_count_advertisments,
                'auctions_numbers'          => $user_count_auctions,
                "user_date"                 => $this->created_at ?  Carbon::parse($this->created_at)->format('Y') : '',
                'status'                    => $this->status,
                'advertisment'              => $resource_advertisments,
                'auctions'                  => $resource_auctions,
            ];
    }
}
