<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class advimagesResource extends JsonResource
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
            'id'                    =>          $this->id,
            'adv_id'                =>          $this->adv_id,
            'img'                   =>          asset('uploads/adverisments/'.$this->img),

        ];
    }
}
