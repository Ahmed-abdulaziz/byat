<?php

namespace App\Http\Resources;
use App\Auctions;
use App\Advertisments;
use App\Notifications;
use Illuminate\Http\Resources\Json\JsonResource;
use App\free_advertisments;
use Carbon\Carbon;
class userProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
         $unread_messages = Notifications::where("user_id" , $this->id)->where("readed" , 0)->count();
        
            $current_month = Carbon::now()->format('Y-m');
            $check_free_month =free_advertisments::Where('month', 'like', '%' . $current_month . '%')->first();
                if($check_free_month){
                    $adv_this_month = Advertisments::withTrashed()->where('user_id',$this->id)->where('created_at', 'like', '%' . $current_month . '%')->count();
                    $count = ($check_free_month->number + $this->adv_number) - $adv_this_month;
                 }
                     
       
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'email'                     => $this->email ? $this->email : '',
            'phone'                     => $this->phone ? $this->phone : '',
            'image'                     => asset('uploads/user_images/'.$this->img),
            'adv_numbers'               => $check_free_month ? $count : $this->adv_number,
            'auctions_numbers'          => $this->auctions_number <= 0 ? 0 : $this->auctions_number,
            'status'                    => $this->status,
            'unread_messages'           => $unread_messages,
            'api_token'                 => $this->api_token,
            ];
    }
}
