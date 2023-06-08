<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class updateimagesResponse extends JsonResource
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
            'id'            =>          $this->id,
            'img'           =>          asset('uploads/adv/'.$this->img) ?: asset('uploads/adv/'),
        ];
    }
}
