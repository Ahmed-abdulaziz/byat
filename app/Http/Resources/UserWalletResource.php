<?php

namespace App\Http\Resources;

use App\Models\Advimages;
use App\Models\appUsers;
use App\users_wallet;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserWalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $user_id = $this->user_id;
        $auction_id = $this->auction_id;
        $amount = $this->amount;
        
        $comment = 'تامين المزاد';
        
                 users_wallet::create([
                    'user_id'=>$user_id,
                    'auction_id' => $auction_id,
                    'money' => $amount,
                    'comment'=> $comment
            ]);
            
            return ['done'];

    }
}
