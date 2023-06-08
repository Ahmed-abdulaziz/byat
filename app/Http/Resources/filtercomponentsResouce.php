<?php

namespace App\Http\Resources;
use App\category_item_components;
use Illuminate\Http\Resources\Json\JsonResource;
class filtercomponentsResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
         $child = category_item_components::where('parent_category_components' ,$this->id)->count();
            return[
                    'id'                    =>        $this->id,
                    'name'                  =>        $this->name,
                    'image'                 =>       $this->image ? asset('uploads/catgoires/filter_selection/'.$this->image) : '',
                    'has_child'             =>        $child > 0 ? true : false,
            ];

    }
}
