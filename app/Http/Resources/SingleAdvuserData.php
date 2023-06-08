<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleAdvuserData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if ($this->email==null){
            $email="";
        }else{
            $email=$this->email;
        }
        if ($this->phone==null){
            $phone="";
        }else{
            $phone=$this->phone;
        }
        if ($this->adv_number<=0){
            $advnum=0;
        }else{
            $advnum=$this->adv_number;
        }
        return [
            'id'            =>          $this->id,
            'name'          =>          $this->name,
            'email'         =>          $email,
            'phone'         =>          $phone,
            'suspend'       =>          $this->suspend,
            'image'         =>          asset('/uploads/user_images/'.$this->img),
        ];
    }
}
