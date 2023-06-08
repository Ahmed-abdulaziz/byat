<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BanarsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'img'                            =>             $this->img ? asset('uploads/banars/'.$this->img) : '',
            'link'                          =>              $this->link,
        ];
    }
}
