<?php

namespace App\Http\Resources\Sream;

use App\Models\area;
use App\Models\city;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AllAdvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $city=city::find($this->city_id);
        $area=area::find($this->area_id);
        if (app()->getLocale()=='ar'){
            $city_name=$city->name_ar;
            $area_name=$area->name_ar;
        }else{
            $city_name=$city->name_en;
            $area_name=$area->name_en;
        }
        $iamge=DB::table('advimages')->where('adv_id','=',$this->id)->first();
        if($iamge){
            $image=asset('uploads/adverisments/'.$iamge->img);
        }else{
            $image=asset('uploads/adverisments/');
        }
        $cheack=DB::table('favoritesadvs')->where('user_id',$this->check_id)->where('adv_id',$this->id)->value('status');
        if ($cheack==0){
            $saved=false;
        }else{
            $saved=true;
        }
        return [
            'id'              =>             $this->id,
            'img'             =>            $image,
            'user_id'         =>            $this->user_id,
            'title'           =>             $this->title,
            'price'           =>             $this->price,
            'city_name'       =>             $city_name,
            'area_name'       =>             $area_name,
            'saved'           =>             $saved,
            'active'          =>             $this->active,
            'special'         =>             $this->special,
                'enddate'         =>             strtotime($this->enddate) ?: 0,
            'created_at'      =>             strtotime($this->created_at),

        ];
    }
}
