<?php

namespace App\Http\Resources\Sreem;

use App\Banars;
use App\Http\Resources\CatgeoryResouce;
use App\Http\Resources\Sream\BanrResponse;
use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $catgoreies=Catgories::all()->where('parent_id','=',$this['parent_id']);
        $cats=CatgeoryResouce::collection($catgoreies);
        $banars=Banars::all()->where('type','=',2)->where('cat_id','=',$this['parent_id']);
        $bans=BanrResponse::collection($banars);
        return [
            'banars'            =>     $bans,
            'catgoreies'        =>     $cats,
        ];
    }
}
