<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class usingPlicyCotoller extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (app()->getLocale()=='ar'){
            $using=$this->usingplicy_ar;
            $about=$this->aboutapp_ar;
        }else{
            $using=$this->usingplicy_en;
            $about=$this->aboutapp_en;
        }

        return[
             'usingPolicy'=>$using,
             'aboutApp'=>$about,
             'callus'=>[
                 'faceBook'=>$this->facebook ? $this->facebook : '',
                 'twwiter'=>$this->twwiter ? $this->twwiter : '',
                 'instgram'=>$this->instgram ? $this->instgram : '',
                 'youtube'=> $this->youtube ? $this->youtube : '',
                 'whatsapp'=>$this->whatsapp ? $this->whatsapp : '',
                 'email'=>$this->email ? $this->email : '', 
                 'phone'=>$this->phone ? $this->phone : '', 
             ],

        ];
    }
}
