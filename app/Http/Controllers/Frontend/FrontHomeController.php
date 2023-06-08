<?php

namespace App\Http\Controllers\Frontend;

use App\CommercialAdv;
use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\carBrandsandModelsResouce;
use App\Http\Resources\CatgeoryResouce;
use App\Http\Resources\CommercailAdds;
use App\Http\Resources\Frontend\DynamicDataResource;
use App\Http\Resources\Frontend\headerFooterResource;
use App\Http\Resources\Frontend\HomeadvsResource;
use App\Http\Resources\Frontend\HomeResource;
use App\Http\Resources\HomeCommAddverResource;
use App\Http\Resources\HomescreenResource;
use App\Http\Resources\singleAdvResource;
use App\Models\Advertisments;
use App\Models\appSettings;
use App\Models\carBrands;
use App\Models\Catgories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontHomeController extends Controller
{
    public function index(){
        $appseting=appSettings::first();
        return view('welcome',compact('appseting'));

//        $home=[];
//        $home=collect($home);
//        if (!isset(Auth::guard('customer')->user()->id)){
//            $home->check_id=0;
//        }else{
//            $home->check_id=Auth::guard('customer')->user()->id;
//        }
//        $home->city_id=0;
//        $home->area_id=0;
//        $resource=HomeResource::make($home);
//        $data=collect($resource);
//        $brands=carBrands::latest()->get();
//        $resource=carBrandsandModelsResouce::collection($brands);
//        $carbrands=collect($resource);
//        $id=0;
//        $xyz= new headerFooterResource($id);
//        $xyzx=collect($xyz);
//        $Setting=DB::table('app_settings')->first();
//        return view('frontend.index',compact('data','carbrands','xyzx','Setting'));
    }


    public function allcategories(){
        $id=0;
        $xyz= new headerFooterResource($id);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        return view('frontend.allcat',compact('xyzx','Setting'));
    }

    public function singleadv($id){
        $xyz= new headerFooterResource($id);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $single=Advertisments::find($id);
        $single->check_id=0;
        $resource=new singleAdvResource($single);
        $singlea=collect($resource);
        if ($single->type==0){
            return view('frontend.carsingle',compact('xyzx','Setting','singlea'));
        }else if ($single->type==1){
            return view('frontend.buldingsingle',compact('xyzx','Setting','singlea'));
        }else{
            return view('frontend.othersingle',compact('xyzx','Setting','singlea'));
        }
    }


    public function alladdlater(){
        $id=0;
        $xyz= new headerFooterResource($id);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat=Advertisments::where('special','=',-1)->latest()->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $latest=HomeadvsResource::collection($lat);
        $all=collect($latest);
        return view('frontend.alladdlater',compact('xyzx','Setting','all'));
    }// add later


    public function allbrandadv($id){

        $xyz= new headerFooterResource($id);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat=Advertisments::where('special','=',-1)->where('brand_id','=',$id)->latest()->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $latest=HomeadvsResource::collection($lat);
        $all=collect($latest);
        return view('frontend.allbrandater',compact('xyzx','Setting','all'));
    }

    public function search(Request $request){

        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat= Advertisments::where('about', 'like', "%".$request->keyword."%")->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $latest=HomeadvsResource::collection($lat);
        $all=collect($latest);
        return view('frontend.searchreasult',compact('xyzx','Setting','all'));
    }


    public function getcat($id){
        $xyz= new headerFooterResource($id);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat=Advertisments::where('cat_id','=',$id)->latest()->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $subs=Catgories::all()->where('parent_id','=',$id);
        $resourcect=CatgeoryResouce::collection($subs);
        $latest=HomeadvsResource::collection($lat);
        $all=collect($latest);
        $type=DB::table('catgories')->where('id',$id)->value('parent_id');
        if ($id==1  && $type ==null){
            return view('frontend.allcars',compact('xyzx','Setting','all','resourcect'));
        }elseif ($id==2 &&  $type ==null){
            return view('frontend.allbulding',compact('xyzx','Setting','all','resourcect'));
        }elseif($id!=1 && $id!=2 && $type ==null){
            $cat=Catgories::find($id);
            $thiccat=new CatgeoryResouce($cat);
            $thiscatC=collect($thiccat);
            return view('frontend.allother',compact('xyzx','Setting','all','resourcect','thiscatC'));
        }

    }

    public function getsubcat(Request $request,$id){

        $xyz= new headerFooterResource($id);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat=Advertisments::when($request->cat_id, function ($query) use ($request) {
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
        })->when($request->model_id, function ($query) use ($request) {
            return $query->where('model_id', $request->model_id);
        })->when($request->year, function ($query) use ($request) {
            return $query->where('year', $request->year);
        })->when($request->status_id, function ($query) use ($request) {
            return $query->where('status_id', $request->status_id);
        })->when($request->color_id, function ($query) use ($request) {
            return $query->where('color_id', $request->color_id);
        })->when($request->shape_id, function ($query) use ($request) {
            return $query->where('shape_id', $request->shape_id);
        })->when($request->shape, function ($query) use ($request) {
            return $query->where('shape_id', $request->shape);
        })->when($request->door_number, function ($query) use ($request) {
            return $query->where('door_number', $request->door_number);
        })->when($request->seat_number, function ($query) use ($request) {
            return $query->where('seat_number', $request->seat_number);
        })->when($request->tranmation, function ($query) use ($request) {
            return $query->where('cartransmissions_id', $request->tranmation);
        })->when($request->enginetypes, function ($query) use ($request) {
            return $query->where('carenginetype_id', $request->enginetypes);
        })->when($request->fueltype_id, function ($query) use ($request) {
            return $query->where('fueltype_id', $request->fueltype_id);
        })->when($request->kilomaterfrom, function ($query) use ($request) {
            return $query->whereBetween('kilometers', [$request->kilomaterfrom, $request->kilomaterto]);
        })->when($request->latest,function ($query) use ($request){
            return $query->orderBy('created_at','DESC');
        })->when($request->oldest,function ($query) use ($request){
            return $query->orderBy('created_at','ASC');
        })->when($request->price_from,function ($query) use ($request){
            return $query->where('price','<=',$request->price_from);
        })->when($request->price_to,function ($query) use ($request){
            return $query->where('price','>=',$request->price_to);
        })->when($request->realsatetype_id, function ($query) use ($request) {
            return $query->where('realstattype_id', '=', $request->realsatetype_id);
        })->when($request->realsatepreiod_id, function ($query) use ($request) {
            return $query->where('realstatperiod_id', '=', $request->realsatepreiod_id);
        })->when($request->realstatepurpose, function ($query) use ($request) {
            return $query->where('realstatepurpose', '=', $request->realstatepurpose);
        })->when($request->roomnumbers, function ($query) use ($request) {
            return $query->where('roomnumber', '=', $request->roomnumbers);
        })->when($request->tolitnumbers, function ($query) use ($request) {
            return $query->where('tolietnumber', '=', $request->tolitnumbers);
        })->where('sub_id','=',$id)->latest()->get();
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=0;
        }
        $subs=Catgories::all()->where('parent_id','=',$id);
        $resourcect=CatgeoryResouce::collection($subs);
        $latest=HomeadvsResource::collection($lat);
        $all=collect($latest);


        $type=DB::table('catgories')->where('id',$id)->value('parent_id');
        $Catgories=DB::table('catgories')->where('id',$id);
        $dynamidataResource=new DynamicDataResource($Catgories);
        $dynamic=collect($dynamidataResource);
        if ($type ==1){
            return view('frontend.filter',compact('type','id','xyzx','Setting','all','resourcect','dynamic'));
        }elseif ($type ==2){
            return view('frontend.filter',compact('type','id','xyzx','Setting','all','resourcect','dynamic'));
        }elseif($type!=1 && $type!=2 ){
            $cat=Catgories::find($id);
            $thiccat=new CatgeoryResouce($cat);
            $thiscatC=collect($thiccat);
            return view('frontend.filter',compact('type','id','xyzx','Setting','all','resourcect','thiscatC'));
        }

    }

    public function commericaldds(Request $request){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat=CommercialAdv::when($request->cat_id,function ($q) use ($request){
            return $q->where('cat_id',$request->cat_id);
        })->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $subs=Catgories::all()->where('parent_id','=',null);
        $resourcect=CatgeoryResouce::collection($subs);
        $latest=HomeCommAddverResource::collection($lat);
        $all=collect($latest);
        return view('frontend.commadds',compact('xyzx','Setting','all','resourcect'));
    }


    public function getcommericaldds($id){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $lat=CommercialAdv::where('cat_id',$id)->get();
        if (!isset(Auth::guard('customer')->user()->id)){
            $check_id=0;
        }else{
            $check_id=Auth::guard('customer')->user()->id;
        }
        foreach ($lat as $key=>$ab){
            $lat[$key]->check_id=$check_id;
        }
        $subs=Catgories::all()->where('parent_id','=',null);
        $resourcect=CatgeoryResouce::collection($subs);
        $latest=HomeCommAddverResource::collection($lat);
        $all=collect($latest);
        return view('frontend.commadds',compact('xyzx','Setting','all','resourcect'));
    }
}
