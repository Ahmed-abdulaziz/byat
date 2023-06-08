<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class packagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     
        if( $this->type < 2){
              return  [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'adv_number'                    => $this->adv_num,
                'price'                         => $this->price,
                'type'                          => $this->type,
                'img'                           => $this->image ? asset('uploads/packages/'.$this->image) : '',
                'color'                         => $this->color ? $this->color  : '' ,
                'details'                       => $this->details ? $this->details : '',
            ];   
        }else{
             return  [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'period'                        => $this->period,
                'price'                         => $this->price,
                'type'                          => $this->type,
                'img'                           => $this->image ? asset('uploads/packages/'.$this->image) : '',
                'color'                         => $this->color ? $this->color  : '' ,
                'details'                       => $this->details ? $this->details : '',
            ]; 
        }
       
    }
}
