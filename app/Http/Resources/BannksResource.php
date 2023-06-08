<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannksResource extends JsonResource
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
            'id'                            =>              $this->id,
            'name'                          =>              $this->name,
            'about'                          =>             $this->about ?? "",
            'img'                           =>              asset('uploads/banks/'.$this->image),
            'account_Number'                =>              $this->account_number,
            'price'                         =>              $this->iban,
        ];
    }
}
