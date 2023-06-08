<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleCommercailAdds extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            =>           $this->id,
            'phone'         =>           $this->phone,
            'whatsapp'      =>           $this->whatsapp,
            'address'       =>           $this->address,
            'lat'           =>           $this->lat,
            'long'          =>           $this->long,
            'img'           =>           asset('uploads/adverisments/'.$this->img),
        ];
    }
}
