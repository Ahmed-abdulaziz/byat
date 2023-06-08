<?php

namespace App\Http\Resources;

use App\Models\weakdays;
use Illuminate\Http\Resources\Json\JsonResource;

class launrySingleDayhandel extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $day=weakdays::find($this->day_id);
        if (app()->getLocale()=='ar'){
           $dayname=$day->name_ar;
        }else{
            $dayname=$day->name_en;
        }
        return [
            'day_name'      =>   $dayname,
            'from'          =>   $this->start,
            'to'            =>   $this->end,

        ];
    }
}
