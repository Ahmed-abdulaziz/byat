<?php

namespace App\Http\Resources;

use App\Models\Catgories;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class HomeCommAddverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $iamge=DB::table('advimages')->where('adv_id','=',$this->id)->first();
        if ($iamge){
            $img= asset('uploads/commadds/'.$iamge->img);
        }else{
            $img= asset('uploads/commadds/noimg.png');
        }
        $fav=DB::table('favoritesadvs')->where('user_id','=',$this->check_id)->where('adv_id','=',$this->id)->where('status','=',1)->count();
        if ($fav==0){
            $favx=0;
        }else{
            $favx=1;
        }


        $cat=new CatgeoryResouce(Catgories::find($this->cat_id));
        if ($this->sub_id!=null){
            $subcat=new CatgeoryResouce(Catgories::find($this->sub_id));
            if (app()->getLocale()=='ar'){
                $subname=$subcat->name_ar ? : "";
            }else{
                $subname=$subcat->name_en ? : "";
            }
        }else{
            $subname="";
        }



        return [
            'id'                =>          $this->id,
            'about'             =>          $this->about,
            'phone'             =>          $this->phone,
            'whatsapp'             =>          $this->whatsapp,
            'title'             =>          $this->title,
            'price'             =>          $this->price,
            'img'               =>          asset('uploads/commadds/'.$this->img),
            'favourite'         =>          $favx,
            'special'           =>          $this->special,
            'enddate'           =>          strtotime($this->enddate) ? : 0,
            'lat'               =>          $this->lat,
            'long'              =>          $this->long,
            'category'          =>          $cat,
            'sub_catName'       =>          $subname ? : "",
            'created_at'        =>          $this->created_at
        ];

    }
}
