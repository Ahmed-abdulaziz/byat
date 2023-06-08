<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\Sream\AllAdvResource;
use App\Models\Advertisments;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilterAndRearange extends Controller
{
    use GeneralTrait;
    public function filter(Request $request)
    {
        $rules = [
            'type' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            if ($request->type == 0) {
                $advertiments = Advertisments::when($request->cat_id, function ($query) use ($request) {
                    return $query->where('cat_id', $request->cat_id);
                })->when($request->sub_id, function ($query) use ($request) {
                    return $query->where('sub_id', $request->sub_id);
                })->when($request->city_id, function ($query) use ($request) {
                    return $query->where('city_id', '=', $request->city_id);
                })->when($request->area_id, function ($query) use ($request) {
                    return $query->whereIn('area_id', $request->area_id);
                })->when($request->advertismet_type, function ($query) use ($request) {
                    return $query->where('advertismet_type', '=', $request->advertismet_type);
                })->when($request->has_image, function ($query) use ($request) {
                    return $query->where('has_image', '=', $request->has_image);
                })->when($request->special, function ($query) use ($request) {
                    return $query->where('special', '=', $request->special);
                })->when($request->owner_type, function ($query) use ($request) {
                    return $query->where('owner_type', '=', $request->owner_type);
                })->when($request->priceFrom, function ($query) use ($request) {
                    return $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
                })->when($request->brand_id, function ($query) use ($request) {
                    return $query->where('brand_id', $request->brand_id);
                })->when($request->models, function ($query) use ($request) {
                    return $query->whereIn('model_id', $request->models);
                })->when($request->year, function ($query) use ($request) {
                    return $query->whereIn('year', $request->year);
                })->when($request->status, function ($query) use ($request) {
                    return $query->whereIn('status_id', $request->status);
                })->when($request->colors, function ($query) use ($request) {
                    return $query->whereIn('color_id', $request->colors);
                })->when($request->shape, function ($query) use ($request) {
                    return $query->whereIn('shape_id', $request->shape);
                })->when($request->shape, function ($query) use ($request) {
                    return $query->whereIn('shape_id', $request->shape);
                })->when($request->door_number, function ($query) use ($request) {
                    return $query->whereIn('door_number', $request->door_number);
                })->when($request->seats, function ($query) use ($request) {
                    return $query->whereIn('seat_number', $request->seats);
                })->when($request->tranmation, function ($query) use ($request) {
                    return $query->whereIn('cartransmissions_id', $request->tranmation);
                })->when($request->enginetypes, function ($query) use ($request) {
                    return $query->whereIn('carenginetype_id', $request->enginetypes);
                })->when($request->fulesTypes, function ($query) use ($request) {
                    return $query->whereIn('fueltype_id', $request->fulesTypes);
                })->when($request->kilomaterfrom, function ($query) use ($request) {
                    return $query->whereBetween('kilometers', [$request->kilomaterfrom, $request->kilomaterto]);
                })->when($request->latest,function ($query) use ($request){
                    return $query->orderBy('created_at','DESC');
                })->when($request->oldest,function ($query) use ($request){
                    return $query->orderBy('created_at','ASC');
                })->when($request->pricehigh,function ($query) use ($request){
                    return $query->orderBy('price','DESC');
                })->when($request->pricelow,function ($query) use ($request){
                    return $query->orderBy('price','ASC');
                })->where('active','=',1)->where('type', '=', 0)->paginate(10);
                $id = $this->getUserID($request->bearerToken());
                foreach ($advertiments as $key => $ab) {
                    $advertiments[$key]->check_id = $id;
                }
                $resource = alladvertismetsResource::collection($advertiments);
                return $this->returnData('data', $advertiments);

            } elseif ($request->type == 1) {
                $advertiments = Advertisments::when($request->all(), function ($query) use ($request) {
                    return $query->where('cat_id', $request->cat_id);
                })->when($request->sub_id, function ($query) use ($request) {
                    return $query->where('sub_id', $request->sub_id);
                })->when($request->city_id, function ($query) use ($request) {
                    return $query->where('city_id', '=', $request->city_id);
                })->when($request->area_id, function ($query) use ($request) {
                    return $query->whereIn('area_id', $request->area_id);
                })->when($request->advertismet_type, function ($query) use ($request) {
                    return $query->where('advertismet_type', '=', $request->advertismet_type);
                })->when($request->has_image, function ($query) use ($request) {
                    return $query->where('has_image', '=', $request->has_image);
                })->when($request->special, function ($query) use ($request) {
                    return $query->where('special', '=', $request->special);
                })->when($request->owner_type, function ($query) use ($request) {
                    return $query->where('owner_type', '=', $request->owner_type);
                })->when($request->priceFrom, function ($query) use ($request) {
                    return $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
                })->when($request->realsatetype_id, function ($query) use ($request) {
                    return $query->whereIn('realstattype_id', '=', $request->realsatetype_id);
                })->when($request->realsatepreiod_id, function ($query) use ($request) {
                    return $query->where('realstatperiod_id', '=', $request->realsatepreiod_id);
                })->when($request->realstatepurpose, function ($query) use ($request) {
                        return $query->where('realstatepurpose', '=', $request->realstatepurpose);
                })->when($request->roomnumbers, function ($query) use ($request) {
                    return $query->where('roomnumber', '=', $request->roomnumbers);
                })->when($request->tolitnumbers, function ($query) use ($request) {
                    return $query->where('tolietnumber', '=', $request->tolitnumbers);
                })->when($request->latest,function ($query) use ($request){
                    return $query->orderBy('created_at','DESC');
                })->when($request->oldest,function ($query) use ($request){
                    return $query->orderBy('created_at','ASC');
                })->when($request->pricehigh,function ($query) use ($request){
                    return $query->orderBy('price','DESC');
                })->when($request->pricelow,function ($query) use ($request){
                    return $query->orderBy('price','ASC');
                })->where('type', '=', 1)->paginate(10);
                $id = $this->getUserID($request->bearerToken());
                foreach ($advertiments as $key => $ab) {
                    $advertiments[$key]->check_id = $id;
                }
                $resource = alladvertismetsResource::collection($advertiments);
                return $this->returnData('data', $advertiments);

            } else {
                $advertiments = Advertisments::when($request->all(), function ($query) use ($request) {
                    return $query->where('cat_id', $request->cat_id);
                })->when($request->sub_id, function ($query) use ($request) {
                    return $query->where('sub_id', $request->sub_id);
                })->when($request->city_id, function ($query) use ($request) {
                    return $query->where('city_id', '=', $request->city_id);
                })->when($request->area_id, function ($query) use ($request) {
                    return $query->whereIn('area_id', $request->area_id);
                })->when($request->advertismet_type, function ($query) use ($request) {
                    return $query->where('advertismet_type', '=', $request->advertismet_type);
                })->when($request->has_image, function ($query) use ($request) {
                    return $query->where('has_image', '=', $request->has_image);
                })->when($request->special, function ($query) use ($request) {
                    return $query->where('special', '=', $request->special);
                })->when($request->owner_type, function ($query) use ($request) {
                    return $query->where('owner_type', '=', $request->owner_type);
                })->when($request->latest,function ($query) use ($request){
                    return $query->orderBy('created_at','DESC');
                })->when($request->oldest,function ($query) use ($request){
                    return $query->orderBy('created_at','ASC');
                })->when($request->pricehigh,function ($query) use ($request){
                    return $query->orderBy('price','DESC');
                })->when($request->pricelow,function ($query) use ($request){
                    return $query->orderBy('price','ASC');
                })->where('type', '!=', (1 || 0))->paginate(10);
                $id = $this->getUserID($request->bearerToken());
                foreach ($advertiments as $key => $ab) {
                    $advertiments[$key]->check_id = $id;
                }
                $resource = alladvertismetsResource::collection($advertiments);
                return $this->returnData('data', $advertiments);

            }
        }
    }//end filter



    public function rearange(Request $request){
        $advertiments=Advertisments::when($request->latest,function ($query) use ($request){
           return $query->orderBy('created_at','DESC');
        })->when($request->oldest,function ($query) use ($request){
            return $query->orderBy('created_at','ASC');
        })->when($request->pricehigh,function ($query) use ($request){
            return $query->orderBy('price','DESC');
        })->when($request->pricelow,function ($query) use ($request){
            return $query->orderBy('price','ASC');
        })->get();
        $id=$this->getUserID($request->bearerToken());
        foreach ($advertiments as $key=>$ab){
            $advertiments[$key]->check_id=$id;
        }
        $resource=alladvertismetsResource::collection($advertiments);
        return $this->returnData('data',$resource);
    }//end Rearange

    public function getadds(Request $request){
          $id=$this->getUserIDNOt($request->bearerToken());
          $today=date('Y-m-d');
          Advertisments::where('special',1)->whereDate('enddate','<=',Carbon::today())->update(['special'=>-1,'enddate'=>null]);

          if ($request->has('latitude') && $request->has('longitude')){
              $ads=Advertisments::when($request->cat_id ,function ($q) use($request){
                  return $q->where('cat_id',$request->cat_id);
              })->when($request->sub_cat_id ,function ($q) use($request){
                  return $q->whereIn('sub_id',$request->sub_cat_id);
              })->select([
                  '*',
                  DB::raw("6371 * acos(cos(radians(" . $request['latitude'] . ")) * cos(radians(latitude))
             * cos(radians(longitude) - radians(" . $request['longitude'] . "))+
             sin(radians(" . $request['latitude'] . ")) * sin(radians(latitude))) AS distance")])->latest()->paginate(10);

              foreach ($ads as $key => $ab) {
                  $ads[$key]->check_id = $id;
              }
              $resource=AllAdvResource::collection($ads);
              return $this->returnData('adds',$ads);

          }else{
              $ads=Advertisments::when($request->cat_id ,function ($q) use($request){
                  return $q->where('cat_id',$request->cat_id);
              })->when($request->sub_cat_id ,function ($q) use($request){
                  return $q->whereIn('sub_id',$request->sub_cat_id);
              })->when($request->city_id ,function ($q) use($request){
                  return $q->where('city_id',$request->city_id);
              })->when($request->area_id ,function ($q) use($request){
                  return $q->whereIn('area_id',$request->area_id);
              })->when($request->brand_id ,function ($q) use($request){
                  return $q->where('brand_id',$request->brand_id);
              })->when($request->model_id ,function ($q) use($request){
                  return $q->whereIn('model_id',$request->model_id);
              })->when($request->roomnumber ,function ($q) use($request){
                  return $q->where('roomnumber',$request->roomnumber);
              })->when($request->year ,function ($q) use($request){
                  return $q->whereIn('year',$request->year);
              })->when($request->kilometers_from_to ,function ($q) use($request){
                  return $q->where('kilometers',$request->kilometers_from_to);
              })->when($request->placearea_from ,function ($q) use($request){
                  return $q->where('placearea','<=',$request->placearea_from);
              })->when($request->placearea_to ,function ($q) use($request){
                  return $q->where('placearea','>=',$request->placearea_to);
              })->when($request->price_from ,function ($q) use($request){
                  return $q->where('price','<=',$request->price_from);
              })->when($request->price_to ,function ($q) use($request){
                  return $q->where('price','>=',$request->price_to);
              })->where('active','=',1)->orderBy('special','DESC')->orderBy('enddate','DESC')->latest()->paginate(10);
              foreach ($ads as $key => $ab) {
                  $ads[$key]->check_id = $id;
              }
              $resource=AllAdvResource::collection($ads);
              return $this->returnData('adds',$ads);
          }

    }

    public function catgoryadv(Request $request){
        $id=$this->getUserIDNOt($request->bearerToken());
        $rules=[
            'cat_id'        =>              'required',
        ];
        $valdator=Validator::make($request->all(),$rules);
        if ($valdator->fails()){
            $code=$this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code,$valdator);
        }else{
            $advertiments=DB::table('advertisments')->where('cat_id','=',$request->cat_id)->orWhere('sub_id','=',$request->cat_id)->where('active','=',1)->latest()->get();
            foreach ($advertiments as $key=>$ab){
                $advertiments[$key]->check_id=$id;
            }
            $resource=alladvertismetsResource::collection($advertiments);
            return $this->returnData('data',$resource);
        }

    }//end catadv

}
