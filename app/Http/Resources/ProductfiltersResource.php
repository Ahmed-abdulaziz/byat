<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\category_items;
use App\category_item_components;
use App\category_item_inputs;
class ProductfiltersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        
        $filter = category_items::find($this->category_item_id);
        if($filter->type != 3){
            $subfilter = category_item_components::find($this->category_item_component_id);
            $subname = $subfilter ? $subfilter->name : '';
                return[
                        "filter_id"                     => $filter->id,
                        "filter"                        => $filter->name,
                        "subfilter_id"                  => $subfilter ?  $subfilter->id : 0,
                        "subfilter"                     => $subfilter ?  $subfilter->name : '',
                        "type"                          => $filter->type,
                        'image'                         => $subfilter && $subfilter->image ? asset('uploads/catgoires/filter_selection/'.$subfilter->image) : ''
                    ];
                    
        }else{
             $subfilter = category_item_inputs::find($this->category_item_component_id);
             $subname = $this->text;
                 return[
                       "filter_id"                      => $filter->id,
                        "filter"                        => $filter->name,
                        "subfilter_id"                  => $subfilter ?  $subfilter->id : 0,
                        "subfilter"                     => $subfilter ? $subfilter->title : '',
                        "type"                          => $filter->type,
                        "text"                          => $subname,
                    ];
        }

    }
}
