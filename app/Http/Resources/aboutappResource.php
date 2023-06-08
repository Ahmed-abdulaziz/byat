<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class aboutappResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (app()->getLocale()=='ar')
        {
            $about=$this->aboutapp_ar;
        }else{
            $about=$this->aboutapp_en;
        }
        return [

            'aboutApp'=>$about,

        ];
    }
}
