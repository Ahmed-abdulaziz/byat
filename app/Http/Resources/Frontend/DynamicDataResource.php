<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\carBrandsandModelsResouce;
use App\Http\Resources\carnumbersResouce;
use App\Http\Resources\carStatusResouce;
use App\Http\Resources\CatgeoryResouce;
use App\Http\Resources\cityandareaResource;
use App\Models\carBrands;
use App\Models\Carcolors;
use App\Models\Cardoors;
use App\Models\Carenginetype;
use App\Models\Carfules;
use App\Models\carModels;
use App\Models\Carseats;
use App\Models\Carshapes;
use App\Models\Carstatus;
use App\Models\Cartransmission;
use App\Models\Catgories;
use App\Models\city;
use App\Models\realstateperiod;
use App\Models\realstatetype;
use Illuminate\Http\Resources\Json\JsonResource;

class DynamicDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $maincat=Catgories::all()->where('parent_id','=',null)->where('id','!=',1)->where('id','!=',2);
        $maincatresource=CatgeoryResouce::collection($maincat);
        if (isset($this->id)){
            $catgoreies=Catgories::all()->where('parent_id','=',$this->id);
        }else{
            $catgoreies=Catgories::all()->where('parent_id','=',1);
        }

        $catgoreiesresource=CatgeoryResouce::collection($catgoreies);
        $models=carModels::all()->where('active','=',1)->where('brand_id','=',$request->brand_id);
        $modelsresource=carBrandsandModelsResouce::collection($models);
        $city=city::all();
        $cityresource=cityandareaResource::collection($city);
        $brands=carBrands::all()->where('active','=',1);
        $brandsresource=carBrandsandModelsResouce::collection($brands);

        return [
            'maincat'           =>$maincatresource,
            'catgoreies'        =>$catgoreiesresource,
            'brands'            =>$brandsresource,
            'models'            =>$modelsresource,
            'city'              =>$cityresource,


        ];

    }
}
