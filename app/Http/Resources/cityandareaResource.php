<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class cityandareaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (app()->getLocale()=='ar'){
           $name=$this->name_ar;
        }else{
            $name=$this->name_en;
        }

        return [
            'id'           =>   $this->id,
             'name'        =>$name,

        ];
    }
}
