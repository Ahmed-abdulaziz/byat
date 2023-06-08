<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use App\favorites;
use App\packages_subscription;
use App\Models\Packages;
class singleAdvResource extends JsonResource
{
    use GeneralTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
            $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                $id = 0;
            }
            
            $favorites =  favorites::where('user_id', $id)->where('product_id', $this->id)->where('type', 0)->first();
            $imageData = [];
            foreach($this->images as $image){
              $imageData[] = asset('uploads/advimage/'.$image->img);
              
            }

          $checkpackage = packages_subscription::where('user_id',$this->user_id)->where('adv_id',$this->id)->orderBy('id','DESC')->first();
            $pack['name'] ='';
            $pack['color'] = '';
          if($checkpackage){
              $package = Packages::find($checkpackage->package_id);
              $pack['name'] =$package->name;
              $pack['color'] = $package->color ?  $package->color : '';
          }
        return [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'phone'                         => $this->phone,
                'price'                         => $this->price,
                'star'                          => $this->star,
                'favorite'                      => $favorites ? 1 : 0,
                'end_star'                      => $this->end_star ? $this->end_star : '' ,
                "image"                         => $this->images->first() ? asset('uploads/advimage/'.$this->images->first()->img) : '',
                'date'                          => Carbon::parse($this->created_at)->format('Y-m-d H:i:s') ,
                "created_at"                    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                "updated_at"                    => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
                'package'                       => $pack ,
        ];

    }
}
