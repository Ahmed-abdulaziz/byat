<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Caetgoryxwithsubs;
use App\Http\Resources\CatgeoryResouce;
use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;

class headerFooterResource extends JsonResource
{

    public function toArray($request)
    {
        $catsx=Catgories::where('parent_id','=',null)->take(4)->get();
        $catsall=Catgories::where('parent_id','=',null)->get();
        $catgoriesx=Caetgoryxwithsubs::collection($catsx);
        $catgoriesall=CatgeoryResouce::collection($catsall);
        return [
            'categoriesx'               =>                $catgoriesx  ,
            'categoriesall'               =>                $catgoriesall  ,
        ];
    }
}
