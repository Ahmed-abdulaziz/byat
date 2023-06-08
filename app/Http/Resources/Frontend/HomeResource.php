<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\CatgeoryResouce;
use App\Models\Advertisments;
use App\Models\Banar;
use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cats=Catgories::where('parent_id','=',null)->take(6)->get();

        $catgories=CatgeoryResouce::collection($cats);

        $recommen=Advertisments::when($this->city_id,function ($query) {
            return $query->where('city_id',$this->city_id);
        })->when($this->area_id,function ($query){
            return $query->where('area_id',$this->area_id);
        })->where('special','=',1)->latest()->take(8)->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($recommen as $key=>$ab){
            $recommen[$key]->check_id=$check_id;
        }
        $recommended=HomeadvsResource::collection($recommen);
        $lat=Advertisments::when($this->city_id,function ($query) {
            return $query->where('city_id',$this->city_id);
        })->when($this->area_id,function ($query){
            return $query->where('area_id',$this->area_id);
        })->where('special','=',-1)->latest()->take(8)->get();
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $latest=HomeadvsResource::collection($lat);
        $banars=Banar::all();
        return [
            'categories'               =>                $catgories  ,
            'recommended'              =>                $recommended,
            'latest'                   =>                $latest ,
            'banars'                   =>                $banars ,
        ];
    }
}
