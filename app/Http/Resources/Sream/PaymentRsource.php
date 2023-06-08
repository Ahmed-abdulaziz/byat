<?php

namespace App\Http\Resources\Sream;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentRsource extends JsonResource
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
            'id'                    =>                  $this->id,
            'name'                  =>                  $this->name,
            'address'               =>                  $this->address,
            'lat'                   =>                  $this->lat,
            'long'                  =>                  $this->lat,
        ];
    }
}
