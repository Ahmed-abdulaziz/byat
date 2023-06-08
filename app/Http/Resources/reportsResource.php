<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
class reportsResource extends JsonResource
{
    use GeneralTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        

          
        return [
                'id'                            => $this->id,
                'name'                          => $this->name,
                'type'                          => $this->type,
      
        ];

    }
}
