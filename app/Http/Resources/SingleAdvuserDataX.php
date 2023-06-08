<?php

namespace App\Http\Resources;

use App\Models\Advertisments;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class SingleAdvuserDataX extends JsonResource
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
        $myadv=Advertisments::all()->where('user_id','=', $this->id);//->where('active','=',1);
        foreach ($myadv as $key=>$ab){
            $myadv[$key]->check_id=$this->check_id;
        }
        $adv=alladvertismetsResource::collection($myadv);
        $bans=DB::table('banusers')->where('second_user','=',$this->id)->count();

        return [
            'id'            =>          $this->id,
            'name'          =>          $this->name,
            'email'         =>          $email ,
            'phone'         =>          $phone,
            'image'         =>          asset('/uploads/user_images/'.$this->img),
            'adv_numbers'   =>          $advnum,
            'type'          =>          $this->type,
            'suspend'       =>          $this->suspend,
            'bans'          =>          $bans ? : 0,
            'ads'           =>          $adv,



        ];
    }
}
