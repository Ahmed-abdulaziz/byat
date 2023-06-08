<?php

namespace App\Http\Resources\Sream;

use Illuminate\Http\Resources\Json\JsonResource;

class BanrResponse extends JsonResource
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
            'id'             =>       $this->id,
            'img'            =>       asset('uploads/banars/'.$this->img),
            'phone'            =>        $this->phone,
            'whatsapp'            =>        $this->whatsapp,
            'link'            =>        $this->link,
        ];
    }
}
