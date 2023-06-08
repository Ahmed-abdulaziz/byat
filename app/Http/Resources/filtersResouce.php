<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\filtercomponentsResouce;
use App\Http\Resources\filterinputsResouce;
class filtersResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){


        if (count($this->components) > 0 && $this->type != 3){
         $components=filtercomponentsResouce::collection($this->components);
          return[
                'id'                        =>       $this->id,
                'name'                      =>       $this->name,
                'type'                      =>       $this->type,
                'can_skip'                  =>       $this->can_skip,
                'componant_have_image'      =>       $this->componant_have_image,
                'check_form'                =>       $this->check_fom,
                'components'                =>       $components,
               
                
            ];
        }else{
            $components=filterinputsResouce::collection($this->components_inputs);
            return[
                'id'                        =>       $this->id,
                'name'                      =>       $this->name,
                'type'                      =>       $this->type,
                'can_skip'                  =>       $this->can_skip,
                'componant_have_image'      =>       $this->componant_have_image,
                'check_form'                =>       $this->check_fom,
                'components'                =>       $components,
               
            ];
        }
    }
}
