<?php

namespace App\Http\Resources;

use App\Models\Advimages;
use App\Models\appUsers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserWalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return($request);
        
        
        $imgs = Advimages::all()->where('adv_id', '=', $this->id);
        $images = advimagesResource::collection($imgs);
        $fav = DB::table('favoritesadvs')->where('user_id', '=', $this->check_id)->where('adv_id', '=', $this->id)->where('status', '=', 1)->count();
        if ($fav == 0) {
            $favx = 0;
        } else {
            $favx = 1;
        }
        $cat = new CatgeoryResouce(Catgories::find($this->cat_id));
        $subcat = new CatgeoryResouce(Catgories::find($this->sub_id));
        if ($subcat) {
            $sub = $subcat;
        } else {
            $sub = (object)[];
        }
        $user = new SingleAdvuserData(appUsers::find($this->user_id));


        $brand = carBrands::find($this->brand_id);
        $model = carModels::find($this->model_id);
        $city = city::find($this->city_id);
        $area = area::find($this->area_id);
        if (app()->getLocale() == 'ar') {
            $brandname = $brand->name_ar ?? '';
            $modelname = $model->name_ar ?? '';
            $cityname = $city->name_ar ?? '';
            $areaname = $area->name_ar ?? '';
        } else {
            $brandname = $brand->name_en ?? '';
            $modelname = $model->name_en ?? '';
            $cityname = $city->name_en ?? '';
            $areaname = $area->name_en ?? '';
        }


        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'about' => $this->about,
            'title' => $this->title,
            'price' => $this->price,
            'cat_id' => $this->cat_id,
            'sub_id' => $this->sub_id,
            'city_id' => $this->city_id,
            'cityname' => $cityname ?: '',
            'area_id' => $this->area_id,
            'areaname' => $areaname ?: '',
            'brand_id' => $this->brand_id ?? 0,
            'branname' => $brandname ?: '',
            'model_id' => $this->model_id ?? 0,
            'modelname' => $modelname ?: '',
            'year' => $this->year ?? "",
              'latitude' => $this->latitude ?? "",
           'longitude' => $this->longitude ?? "",
            'kilometers' => $this->kilometers ?? "",
            'type' => $this->type,
            'special' => $this->special,
            'enddate' => strtotime($this->enddate) ?: 0,
            'placearea' => $this->placearea ?? "",
            'roomnumber' => $this->roomnumber?? "",
            'favourite' => $favx,
            'video_link' => $this->video_link ?? "",
            'category' => $cat,
            'subCategory' => $sub,
            'user_info' => $user,
            'created_at' => (integer)strtotime($this->created_at),
            'imgs' => $images ?: [],
        ];

    }
}
