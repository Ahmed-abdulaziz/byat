<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\HomescreenResource;
use App\Http\Resources\HomeScreenResoutceByLocation;
use App\Models\Advertisments;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class
HomescreenController extends Controller
{
    use GeneralTrait;
    public function getRecomended(Request $request){
        if(isset($request->lat)){
            $id=$this->getUserID($request->bearerToken());
            $advs=Advertisments::distance($request->lat, $request->long);
            $advs=$advs->orderBy('distance', 'ASC')->where('special','=',1)->where('active','=',1)->latest()->paginate(10);
            foreach ($advs as $key=>$ab){
                $advs[$key]->check_id=$id;
            }
            $recomended=alladvertismetsResource::collection($advs);
            return $this->returnData('data',$advs);
        }else{

            $id=$this->getUserID($request->bearerToken());
            $advs=Advertisments::when($request->city_id,function ($query) use($request){
                return $query->where('city_id',$request->city_id);
            })->when($request->area_id,function ($query) use($request){
                return $query->where('area_id',$request->area_id);
            })->where('special','=',1)->where('active','=',1)->paginate(10);
            foreach ($advs as $key=>$ab){
                $advs[$key]->check_id=$id;
            }
            $recomended=alladvertismetsResource::collection($advs);
            return $this->returnData('data',$advs);
        }

    }

    public function getlatest(Request $request){
        if(isset($request->lat)){
            $id=$this->getUserID($request->bearerToken());
            $advs=Advertisments::distance($request->lat, $request->long);
            $advs=$advs->orderBy('distance', 'ASC')->where('special','=',-1)->where('active','=',1)->latest()->paginate(10);
            foreach ($advs as $key=>$ab){
                $advs[$key]->check_id=$id;
            }
            $recomended=alladvertismetsResource::collection($advs);
            return $this->returnData('data',$advs);

        }else{
            $id=$this->getUserID($request->bearerToken());
            $advs=Advertisments::when($request->city_id,function ($query) use($request){
                return $query->where('city_id',$request->city_id);
            })->when($request->area_id,function ($query) use($request){
                return $query->where('area_id',$request->area_id);
            })->where('special','=',-1)->where('active','=',1)->latest()->paginate(10);
            foreach ($advs as $key=>$ab){
                $advs[$key]->check_id=$id;
            }
            $recomended=alladvertismetsResource::collection($advs);
            return $this->returnData('data',$advs);
        }

    }

    public function homescreen(Request $request){
       if(isset($request->lat)){
           $id=$this->getUserID($request->bearerToken());
           $home=[];
           $home=collect($home);
           $home->check_id=$id;
           $home->lat=$request->lat;
           $home->long=$request->long;
           $resource=HomeScreenResoutceByLocation::make($home);
           return $this->returnData('data',$resource);

       }else{
           $id=$this->getUserID($request->bearerToken());
           $home=[];
           $home=collect($home);
           $home->check_id=$id;
           $home->city_id=$request->city_id;
           $home->area_id=$request->area_id;
           $resource=HomescreenResource::make($home);
           return $this->returnData('data',$resource);
       }

    }
}
