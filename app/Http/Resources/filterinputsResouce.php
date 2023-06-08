<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class filterinputsResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
            return[
                'id'                =>        $this->id,
                'title'             =>        $this->title ? $this->title : '',
                'placeholder'       =>        $this->placeholder ? $this->placeholder : '' ,
                'unit'              =>        $this->unit ? $this->unit : '',

            ];

    }
}
