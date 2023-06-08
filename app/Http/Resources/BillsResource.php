<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
class BillsResource extends JsonResource
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
                'id'                                => $this->id,
                'name'                              => $this->name,
                'product'                           => $this->product ? $this->product : '',
                'package'                           => $this->package ? $this->package : '',
                'price'                             => $this->price,
                'date'                              => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];

    }
}
