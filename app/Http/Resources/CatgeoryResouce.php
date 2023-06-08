<?php

namespace App\Http\Resources;

use App\Advertisments;
use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Auctions;
use Carbon\Carbon;
class CatgeoryResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $current_date = Carbon::today()->toDateString();;
        $sub=Catgories::where('parent_id','=',$this->id)->count();
        
     
        $addscount=Advertisments::where('cat_id',$this->id)->where('end_date','>=',$current_date)->count();
        $Auctionscount=Auctions::where('cat_id',$this->id)->wherenotnull('end_date')->where('end_date_in_app','>=',$current_date)->count();
        
        if ($this->img==null){
            
          return[
                'id'            =>       $this->id,
                'name'          =>       $this->name,
                'adds'          =>       $addscount ?? 0,
                'Auctionscount' =>       $Auctionscount,
            ];
        }else{
            return[
                'id'            =>       $this->id,
                'name'          =>       $this->name,
                'img'           =>       asset('uploads/catgoires/'.$this->img) ? : asset('uploads/catgoires/'),
                'has_sub'       =>       $sub ? 1 : 0,
                'adds'          =>       $addscount ?? 0,
                'Auctionscount' =>       $Auctionscount,
            ];


        }
    }
}
