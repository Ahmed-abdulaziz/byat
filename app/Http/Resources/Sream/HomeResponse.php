<?php

namespace App\Http\Resources\Sream;

use App\Banars;
use App\DeviceToken;
use App\Gifts;
use App\Http\Resources\CatgeoryResouce;
use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\VarDumper\Cloner\Data;

class HomeResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $today=Date('Y-m-d');
        $gift=Gifts::where('end_date','>',$today)->first();
         if ($gift){
             if ($this['device_id']){
                  $count=DeviceToken::where('device_tokens',$this['device_id'])->where('status','=',1)->first();
                  if ($count){
                      $gift_status=1;
                  }else{
                      $gift_status=0;
                  }
             }else{
                 $gift_status=0;
             }
        }else{
            $gift_status=0;
        }
        $banar=Banars::where('cat_id',0)->get();
        $ctegores=Catgories::take(5)->get();
        $respose=BanrResponse::collection($banar);
        $respose2=CatgeoryResouce::collection($ctegores);
        return [
            'banars'                    =>            $respose,
            'categories'                =>            $respose2 ,
            'gift_status'                =>            $gift_status ,
        ];
    }
}
