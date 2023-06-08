<?php

namespace App\Http\Resources;

use App\Models\Advertisments;
use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;

class HomescreenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cats=Catgories::where('parent_id','=',null)->take(5)->get();
        $catgories=CatgeoryResouce::collection($cats);
        $recommen=Advertisments::when($this->city_id,function ($query) {
            return $query->where('city_id',$this->city_id);
        })->when($this->area_id,function ($query){
            return $query->where('area_id',$this->area_id);
        })->where('special','=',1)->latest()->take(5)->get();
        foreach ($recommen as $key=>$ab){
            $recommen[$key]->check_id=$this->check_id;
        }
        $recommended=alladvertismetsResource::collection($recommen);
        $lat=Advertisments::when($this->city_id,function ($query) {
            return $query->where('city_id',$this->city_id);
        })->when($this->area_id,function ($query){
            return $query->where('area_id',$this->area_id);
        })->where('special','=',-1)->latest()->take(5)->get();
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$this->check_id;
        }
        $latest=alladvertismetsResource::collection($lat);

        return [
          'categories'               =>                $catgories  ,
          'recommended'              =>                $recommended,
          'latest'                   =>                $latest ,
        ];
    }
}
