<?php

namespace App\Http\Controllers\Api;

use App\CommercialAdv;
use App\DeviceToken;
use App\Gifts;
use App\Http\Resources\CommercailAdds;
use App\Http\Resources\BanarsResource;
use App\Http\Resources\CatgeoryResouce;
use App\Http\Resources\GiftResource;
use App\Http\Resources\SingleCommercailAdds;
use App\Http\Resources\Sream\HomeResponse;
use App\Traits\GeneralTrait;
use App\Vistoer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use function foo\func;
use App\Banars;
use App\Models\Catgories;
use App\Models\appSettings;
use App\Auctions;
use App\Http\Resources\singleAuctionResources;
use Carbon\Carbon;
class HomeController extends Controller
{
    use GeneralTrait;
    public function index(Request $request){
        
            $banners=Banars::whereNull('cat_id')->limit(3)->orderBy('id','DESC')->get();
            $banners=BanarsResource::collection($banners);
            $data['banners'] = $banners;
            
            $Catgories=Catgories::where('parent_id',1)->get();
            $Catgories=CatgeoryResouce::collection($Catgories);
            $data['catgories'] = $Catgories;
            
            return $this->returnData('data',$data);
        

    }

 public function index_auction(Request $request){
        
              $current        = Carbon::today()->toDateString();
         
            $video=appSettings::first(['auctions_introduction_video']);
            $data['video'] = $video ? $video->auctions_introduction_video : '';
            
            $auctions = Auctions::where('end_date','>',$current)->limit(3)->latest()->get();
            $resource=singleAuctionResources::collection($auctions);
            $data['auctions'] = $resource;
             
            $Catgories=Catgories::where('parent_id',2)->get();
            $Catgories=CatgeoryResouce::collection($Catgories);
            $data['catgories'] = $Catgories;
            
            return $this->returnData('data',$data);
        

    }
    
    public function commercialadds(Request $request){
          $comercail=CommercialAdv::when($request->cat_id,function ($q) use ($request){
              return $q->where('cat_id',$request->cat_id);
          })->latest()->paginate(10);
          $response=CommercailAdds::collection($comercail);
          return $this->returnData('adds',$comercail);
    }

    public function singlecommercialadds(Request $request){
        $rules=[
            'add_id'          =>         'required|exists:commercial_advs,id'
        ];
        $valdaitor = Validator::make($request->all(), $rules);
        if ($valdaitor->fails()) {
            $code = $this->returnCodeAccordingToInput($valdaitor);
            return $this->returnValidationError($code, $valdaitor);
        } else {
            $commercialadds=CommercialAdv::find($request->add_id);
            $response=new SingleCommercailAdds($commercialadds);
            return  $this->returnData('data',$response);
        }
    }
    public function getgifts(Request $request)
    {
        $rules=[
            'device_id' => 'required',
        ];
        $valdaitor = Validator::make($request->all(), $rules);
        if ($valdaitor->fails()) {
            $code = $this->returnCodeAccordingToInput($valdaitor);
            return $this->returnValidationError($code, $valdaitor);
        } else {
            $today = Date('Y-m-d');
            $gift = Gifts::where('end_date', '>', $today)->first();
            $device=DeviceToken::where('device_tokens',$request->device_id)->first();
            $gift['device_id']=$device->id;
       $devicex=DeviceToken::where('device_tokens',$request->device_id)->update(['status'=>0]);
            return  $this->returnData('data',new GiftResource($gift));
        }
    }

}
