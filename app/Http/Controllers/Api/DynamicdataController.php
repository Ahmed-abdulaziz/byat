<?php

namespace App\Http\Controllers\Api;

use App\Banks;
use App\Http\Resources\BannksResource;
use App\Http\Resources\carnumbersResouce;
use App\Http\Resources\carStatusResouce;
use App\Http\Resources\CatgeoryResouce;
use App\Http\Resources\BanarsResource;
use App\Http\Resources\cityandareaResource;
use App\Http\Resources\singleAdvResource;
use App\Http\Resources\packagesResource;
use App\Http\Resources\filtersResouce;
use App\Http\Resources\Sream\PaymentRsource;
use App\Http\Resources\Sreem\SubcategoryResource;
use App\Http\Resources\singleAuctionResources;
use App\Http\Resources\filtercomponentsResouce;
use App\Http\Resources\reportsResource;
use App\Models\area;
use App\packages_subscription;
use App\Models\Catgories;
use App\Models\city;
use App\Models\Packages;
use App\Models\appUsers;
use App\Traits\imageTrait;
use App\Advertisments;
use App\Banars;
use App\users_wallet;
use App\Payment_place;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Vistoer;
use App\favorites;
use App\category_item_components;
use App\category_items;
use App\Auctions;
use App\Models\appSettings;
use App\reports;
use App\report_users;
use App\bills;
use App\cash_payment_requests;
use App\Monthly_withdrawals;
class DynamicdataController extends Controller
{
    use GeneralTrait;
    use imageTrait;
    
       
     public function visitor(){
             $currentdate = Carbon::today()->toDateString();
     
                $data =  Vistoer::whereDate('created_at', $currentdate)->first();
                if($data){
                    $data->update([
                       'counter'=> $data->counter + 1 
                    ]);
                }else{
                    Vistoer::create([
                          'counter'=> 1 
                    ]);
                }
               
                return  response(['status' => true]);
    }
    
        public function favorites(Request $request , $type){
          
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
                $currentdate = Carbon::today()->toDateString();
                $products =  favorites::where('user_id', $id)->where('type', $type)->pluck('product_id')->toArray();

                          if($type == 0){             // adv
                          
                                $all_data_star = Advertisments::where('status',1)->where('end_date','>=',$currentdate)->where('end_star','>=',$currentdate)->WhereIn('id',$products)->get();
                                $all_data = Advertisments::where('status',1)->where('end_date','>=',$currentdate)->where(function($q) use ($currentdate) {
                                  $q->where('end_star','<',$currentdate)
                                    ->orWhereNull('end_star');
                                })->WhereIn('id',$products)->get();
               
                                     $resource_star=singleAdvResource::collection($all_data_star);
                                     $resource=singleAdvResource::collection($all_data);
                                     $values = $resource_star->merge($resource);
                                     return $this->returnData('advertimnets', $values);
                         
                            }else{
                                    $all_data = Auctions::WhereIn('id',$products)->get();   
                                    $resource=singleAuctionResources::collection($all_data);
                                    return $this->returnData('auctions', $resource);
                            }
                    
               
    }
    
    
      public function favorite_action(Request $request){
          
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
        
           $rules=[
               'product_id'         =>         'required',
               'type'               =>         'required',
           ];
           $valdaitor=Validator::make($request->all(),$rules);
           if ($valdaitor->fails()){
               $code=$this->returnCodeAccordingToInput($valdaitor);
               return $this->returnValidationError($code,$valdaitor);
           }

                $data =  favorites::where('user_id', $id)->where('product_id', $request->product_id)->where('type', $request->type)->first();
                if(!$data){
                    favorites::create([
                        'user_id'=> $id , 
                        'product_id'=> $request->product_id , 
                        'type'=> $request->type , 
                    ]);
                }else{
                     $data->delete();
                }
               
                return  response(['status' => true]);
    }
    
    
     public function search(Request $request){
        
        $rules=[
               'type'               =>         'required',
           ];
            $valdaitor=Validator::make($request->all(),$rules);
           if ($valdaitor->fails()){
               $code=$this->returnCodeAccordingToInput($valdaitor);
               return $this->returnValidationError($code,$valdaitor);
           }
           
           if($request->type == 1){     // adv
                    $all_data = Advertisments::where('name', 'like', '%' . $request->text . '%' )->orwhere('description', 'like', '%' . $request->text . '%' )->where('end_date','>=',Carbon::today()->toDateString())->orderBy('id','DESC')->get();
                    $resource=singleAdvResource::collection($all_data);
                    return $this->returnData('advertimnets', $resource);
           
           }else{  // Auctions
                        $all_data = Auctions::orderBy('id', 'DESC')->where('name', 'like', '%' . $request->text . '%' )->orwhere('description', 'like', '%' . $request->text . '%' )->where('end_date_in_app','>=',Carbon::today()->toDateString())->orderBy('end_date', 'DESC')->get();
                        $resource=singleAuctionResources::collection($all_data);
                        return $this->returnData('auctions', $resource);  
           }
        
    }
    
    

    
    public function categories(){
        $catgoreies=Catgories::all()->where('active','=',1)->where('parent_id','=',null);
        $resource=CatgeoryResouce::collection($catgoreies);
        return $this->returnData('data',$resource);
    }//end categories



    public function subCatgoires(Request $request){
        
        
        
        $catgoreies=Catgories::where('active','=',1)->where('parent_id','=',$request->cat_id)->orderBy('ordered','ASC')->get();
        $resource=CatgeoryResouce::collection($catgoreies);
        return $this->returnData('data',$resource);
    }//end subCatgoires
    
    
       public function subCatgoires_new(Request $request){
        
        
            
            $catgoreies=Catgories::where('active','=',1)->where('parent_id','=',$request->cat_id)->orderBy('ordered','ASC')->get();
            $number_of_cates = ceil($catgoreies->count() / 6);
            
            $skip = 0;
            $skip_baners = 0;
            $values = [];
            $currentdate = Carbon::today()->toDateString();
            
            for($i=0;$i<$number_of_cates;$i++){
                    $catgoreies=Catgories::where('active','=',1)->where('parent_id','=',$request->cat_id)->orderBy('ordered','ASC')->skip($skip)->take(6)->get(); 
                    $banners=Banars::where('cat_id',$request->cat_id)->where('end_date','>=',$currentdate)->orderBy('ordered','ASC')->skip($skip_baners)->take(1)->get();
                    
                    $banners=BanarsResource::collection($banners);
                    $resource=CatgeoryResouce::collection($catgoreies);
                    $data['banner'] = $banners;
                    $data['catgeory'] = $resource;
                    $values[] = $data;
                    $skip +=6;
                    $skip_baners++;
            }
            
                
           
            return $this->returnData('data',$values);
            
            
    }
    
    
      public function examination_image_catgorie($cat_id){
        $data = Catgories::find($cat_id);
        if($data){
                $appSettings = appSettings::first(); 
                $result['examination_image'] = $data->examination_image == 1 ? true : false;
                $result['examination_image_message'] = $data->examination_image == 1 ? 'required' : 'not required';
                $result['maximum_duration_auction'] =  $appSettings->maximum_duration_auction;
                return $this->returnData('data',$result);
        }
        
       return $this->returnData('status',false, 'Not Found Data');
        
    }
    
    
     public function filters($cat_id,$type = 0){
         if($type != 0){
              $data = category_items::where('cat_id',$cat_id)->wherenull('parent_category_items')->orderBy('ordered','ASC')->get();
         }else{
              $data = category_items::where('cat_id',$cat_id)->orderBy('ordered','ASC')->get();
         }
       
        $resource=filtersResouce::collection($data);
        return $this->returnData('data',$resource);
        
    }
    
    public function filter_details($id){
         
        $data = category_items::find($id);
        if($data){ 
            $resource=new filtersResouce($data);
            return $this->returnData('data',$resource);
        }
                    if (app()->getLocale() == 'ar') {
                        return $this->returnData('status',false, 'الفلتر غير موجود');
                    } else {
                      return $this->returnData('status',false, 'Filter Not Found');
                    }
        
    }


 public function filter_child($filter_id, $componant){
         
            $main = category_items::find($filter_id);
           
            $data = category_items::where('parent_category_items',$filter_id)->get();
            $finish = [];
             if($main && $data->count() > 0){
                  
                    foreach($data as $item){
                            $values['id'] = $item->id; 
                            $values['name'] = $item->name; 
                            $values['type'] = $item->type; 
                            $values['can_skip'] = $item->can_skip; 
                            $values['componant_have_image'] = $item->componant_have_image; 
                            $values['check_form'] = $item->check_form ? $item->check_form : 0; 
                            $child = category_item_components::where('category_item_id' ,$item->id)->where('parent_category_components' ,$componant)->get();
                            $resource=filtercomponentsResouce::collection($child);
                            
                            $values['components'] =$resource; 
                            $finish[] = $values;
                    }
                    
                    return $this->returnData('data',$finish);
            }
            
                  if (app()->getLocale() == 'ar') {
                        return $this->returnError('', 'لا يوجد بيانات');
                    } else {
                        return $this->returnError('', 'Not Found Data');
                    }
         
        
    }
    public function newsubCatgoires(Request $request){

        $resource=new SubcategoryResource(['parent_id'=>$request->cat_id]);
        return $this->returnData('data',$resource);
    }//end subCatgoires


        public function getbanners(){
            $banners=Banars::whereNull('cat_id')->limit(3)->orderBy('id','DESC')->get();
             $banners=BanarsResource::collection($banners);
            foreach($banners as $banner){
                $banner->img =  asset('uploads/banars/'.$banner->img);
                 if($banner->link == NULL){
                     $banner->link = '';
                 }
                $values[] =   $banner;
            }
            return $this->returnData('data',$values);
        }



    public function carstatus(){
         $carStatus=Carstatus::all();
         $resource=carStatusResouce::collection($carStatus);
         return $this->returnData('data',$resource);

    }//end carstatus.


    public function getcolors(){
        $carStatus=Carcolors::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);

    }//end getcolors

    public function getShapes(){
        $carStatus=Carshapes::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }//end getShapes


    public function carDoors(){
     $carDoors=Cardoors::all();
     $resource=carnumbersResouce::collection($carDoors);
     return $this->returnData('data',$resource);
    }//end carDoors



    public function carSeattsnumbers(){
        $carDoors=Carseats::all();
        $resource=carnumbersResouce::collection($carDoors);
        return $this->returnData('data',$resource);
    }//end carSeattsnumbers


    public function carsTranmtionType(){

        $carStatus=Cartransmission::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }//end carsTranmtionType



    public function carFuelType(){
        $carStatus=Carfules::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }//end carFuelType


    public function carengineType(){
        $carStatus=Carenginetype::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }//end carengineType

    public function whealSystemType(){
        $carStatus=Carwheelsystem::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }//end whealSystemType

    public function realstateTypes(){
        $carStatus=realstatetype::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }//end realstateTypes

    public function realstateperiod(){
        $carStatus=realstateperiod::all();
        $resource=carStatusResouce::collection($carStatus);
        return $this->returnData('data',$resource);
    }

    public function cities(){
        $carStatus=city::all();
        $resource=cityandareaResource::collection($carStatus);
        return $this->returnData('data',$resource);
    }
    public function areas(Request $request){
        $carStatus=area::all()->where('city_id',$request->city_id);
        $resource=cityandareaResource::collection($carStatus);
        return $this->returnData('data',$resource);
    }
    public function allareas(){
        $carStatus=area::all();
        $resource=cityandareaResource::collection($carStatus);
        return $this->returnData('data',$resource);
    }

    public function packages(Request $request){
           $rules=[
               'type'      =>         'required',
           ];
           $valdaitor=Validator::make($request->all(),$rules);
           if ($valdaitor->fails()){
               $code=$this->returnCodeAccordingToInput($valdaitor);
               return $this->returnValidationError($code,$valdaitor);
           }else{
               $pacakages=Packages::where('type',$request->type)->get();
               $resource=packagesResource::collection($pacakages);
               return $this->returnData('data',$resource);
           }
    }
    
     public function packages_subscriptions(Request $request){
         
         if(isset($request->paymentmethod)){
             if($request->paymentmethod == 1){                // Cash
              
                 $rules=[
                            'user_id'           =>         'required|integer|exists:app_users,id',
                            'package_id'        =>         'required|integer',
                            'type'              =>         'required|integer',
                       ];
                       
                       if($request->type == 2){
                            $rules=[
                                 'adv_id'      =>         'required|integer',
                              ];
                       }else{
                           $request->adv_id = NULL;
                       }
                       
                       $valdaitor=Validator::make($request->all(),$rules);
                       if ($valdaitor->fails()){
                           $code=$this->returnCodeAccordingToInput($valdaitor);
                           return $this->returnValidationError($code,$valdaitor);
                       }else{
                           $main_package = Packages::find($request->package_id);
                           if($main_package){
                                     cash_payment_requests::create([
                                                'user_id'        =>$request->user_id,
                                                'product_id'    =>$main_package->id,
                                                'adv_id'        =>$request->adv_id ? $request->adv_id : NULL ,
                                                'money'         =>$main_package->price,
                                                'type'          => $request->type,
                                         ]);
                                      if (app()->getLocale() == 'ar') {
                                              $msg = 'طلبك قيد المراجعه';
                                      } else {
                                             $msg = 'Your request is under review';
                                        }
                         
                                 return $this->returnData('msg',$msg);
                                 
                           
                           
                           }else{
                           
                                  if (app()->getLocale() == 'ar') {
                                          $msg = "هذه الباقه غير موجوده";
                                        } else {
                                         $msg = 'This Package Not Found';
                                  }
                                  
                                  return $this->returnData('status',false ,$msg);
                           }
                     
                       }
                       
          
          }elseif($request->paymentmethod == 2){   // wallet
              
                 $rules=[
                            'user_id'           =>         'required|integer|exists:app_users,id',
                            'package_id'        =>         'required|integer',
                            'type'              =>         'required|integer',
                       ];
                       
                       if($request->type == 2){
                            $rules=[
                                 'adv_id'      =>         'required|integer',
                              ];
                       }else{
                           $request->adv_id = NULL;
                       }
                       
                       $valdaitor=Validator::make($request->all(),$rules);
                       if ($valdaitor->fails()){
                           $code=$this->returnCodeAccordingToInput($valdaitor);
                           return $this->returnValidationError($code,$valdaitor);
                       }else{
                           $main_package = Packages::find($request->package_id);
                           if($main_package){
                            //   ------------Check mony Of Wallet ----------------------------------------
                                     $amount=users_wallet::where('user_id',$request->user_id)->sum('money');
                            // ---------------------------------------------------------------------------
                            // echo $amount;die;
                            if($amount >=$main_package->price ){
                                
                                        $user = appUsers::where('id',$request->user_id)->first();
                                                    $old_adv = $user->adv_number;
                                                     $total = $old_adv + $main_package->adv_num;
                                        $last = packages_subscription::create([
                                                    'user_id' => $request->user_id,
                                                     'package_id' => $request->package_id,
                                                    'type' =>  $request->type,
                                                    'adv_id' => $request->adv_id,
                                                    
                                                ]);
                                                
                                                 if($last->type == 0){
                                                   
                                                     $name_ar = 'باقة اعلانات';
                                                    $name_en = 'Ad package';
                                                    
                                                      $user->update([
                                                         'adv_number' => $total
                                                     ]);
                                                 }elseif($last->type == 1){
                                                     
                                                    $name_ar = 'باقة مزادات';
                                                    $name_en = 'Auction package';
                                                    
                                                    $old_auction = $user->auctions_number;
                                                    $total = $old_auction + $main_package->adv_num;
                                                     
                                                      $user->update([
                                                             'auctions_number' => $total
                                                     ]);
                                                 }elseif($last->type == 2){
                                                    
                                                        $name_ar = 'تمييز اعلان';
                                                        $name_en = 'Ad recognition';
                                                        
                                                        $adv_id = $last->adv_id;
                                                        $days = $main_package->period;
                                                        $adv=Advertisments::find($adv_id);
                                                        if($adv){
                                                                $end_date_of_star = Carbon::now()->addDays($days)->format('Y-m-d');  
                                                                  $adv->update([
                                                                      'star' => 1,
                                                                      'end_star'=>$end_date_of_star
                                                                 ]);
                                                        }
                                                 }
                                                  $last->update([
                                                      'status' => 1
                                                     ]);
                                                     
                                                   users_wallet::create([
                                                            'user_id'=> $request->user_id,
                                                            'money'=> $main_package->price * -1 ,
                                                            'comment'=> 'شحن باقه',
                                                     ]);
                                        
                                                   bills::create([
                                                        'user_id'=> $request->user_id,
                                                        'price'=> $main_package->price  ,
                                                        'product'=> $last->type == 2 ? $adv->name : NULL  ,
                                                        'product_id'=> $adv->id,
                                                        'name_ar'=> $name_ar,
                                                        'name_en'=> $name_en,
                                                        'package'=> $main_package->name,
                                                        'payment_method'=> 'Wallet',
                                                    ]);
                                        
                                
                                     
                                    $check =   Monthly_withdrawals::where('month',  Carbon::now()->format('Y-m'))->count();
                                      
                                      if($check > 0){
                                            if (app()->getLocale() == 'ar') {
                                                    $msg = 'تهانينا لك دخلت السحب الشهرى';
                                            }else{
                                                    $msg = 'Congratulations, you entered the monthly draw';
                                            }
                                      }else{
                                          if (app()->getLocale() == 'ar') {
                                                      $msg = 'تم الاشتراك بالباقه بنجاح ';
                                              } else {
                                                     $msg = 'Package has been successfully subscribed ';
                                                }
                                      }
                                      
                                      
                         
                                 return $this->returnData('msg',$msg);
                                 
                            }else{
                                              if (app()->getLocale() == 'ar') {
                                                            return $this->returnData('status',false, 'لا يوجد لديك رصيد كافى فى المحفظه');
                                                     } else {
                                                         return $this->returnData('status',false, 'You dont have enough wallet balance');
                                                        }  
                            }
                           
                           }else{
                               
                                      if (app()->getLocale() == 'ar') {
                                              $msg = "هذه الباقه غير موجوده";
                                            } else {
                                             $msg = 'This Package Not Found';
                                      }
                                      
                           }
                     
                       }
                       
          }elseif($request->paymentmethod == 3){                     // api charge
              
                 $rules=[
                            'user_id'           =>         'required|integer|exists:app_users,id',
                            'package_id'        =>         'required|integer',
                            'type'              =>         'required|integer',
                            'trans_id'          =>         'required',
                       ];
                       
                        
                       if($request->type == 2){
                            $rules=[
                                    'adv_id'            =>         'required|integer',
                                    'user_id'           =>         'required|integer|exists:app_users,id',
                                    'package_id'        =>         'required|integer',
                                    'type'              =>         'required|integer',
                                    'trans_id'          =>         'required',
                              ];
                       }else{
                           $request->adv_id = NULL;
                       }
                       
                       $valdaitor=Validator::make($request->all(),$rules);
                       if ($valdaitor->fails()){
                           $code=$this->returnCodeAccordingToInput($valdaitor);
                           return $this->returnValidationError($code,$valdaitor);
                       }else{
                           
                            // return $this->returnData('msg','Pending ,  api charge');
                            
                           $main_package = Packages::find($request->package_id);
                           if($main_package){
                                        $user = appUsers::where('id',$request->user_id)->first();
                                                    $old_adv = $user->adv_number;
                                                     $total = $old_adv + $main_package->adv_num;
                                        $last = packages_subscription::create([
                                                    'user_id' => $request->user_id,
                                                    'package_id' => $request->package_id,
                                                    'type' =>  $request->type,
                                                    'adv_id' => $request->adv_id,
                                                    'trans_id'=> $request->trans_id
                                                    
                                                ]);
                                                
                                                 if($last->type == 0){
                                                        
                                                    $name_ar = 'باقة اعلانات';
                                                    $name_en = 'Ad package';
                                                    
                                                      $user->update([
                                                         'adv_number' => $total
                                                     ]);
                                                 }elseif($last->type == 1){
                                                     
                                                        $name_ar = 'باقة مزادات';
                                                        $name_en = 'Auction package';
                                                        
                                                     $old_auction = $user->auctions_number;
                                                     $total = $old_auction + $main_package->adv_num;
                                                     
                                                      $user->update([
                                                             'auctions_number' => $total
                                                     ]);
                                                 }elseif($last->type == 2){
                                                    
                                                        $name_ar = 'تمييز اعلان';
                                                        $name_en = 'Ad recognition';

                                                        
                                                        $adv_id = $last->adv_id;
                                                        $days = $main_package->period;
                                                        $adv=Advertisments::find($adv_id);
                                                        if($adv){
                                                                $end_date_of_star = Carbon::now()->addDays($days)->format('Y-m-d');  
                                                                  $adv->update([
                                                                      'star' => 1,
                                                                      'end_star'=>$end_date_of_star
                                                                 ]);
                                                        }
                                                 }
                                                  $last->update([
                                                      'status' => 1
                                                     ]);
                                                     
                                                    
                                                     bills::create([
                                                        'user_id'=> $request->user_id,
                                                        'price'=> $main_package->price  ,
                                                        'product'=> $last->type == 2 ? $adv->name : NULL  ,
                                                        'product_id'=> $adv->id,
                                                        'name_ar'=> $name_ar,
                                                        'name_en'=> $name_en,
                                                        'package'=> $main_package->name,
                                                        'payment_method'=> 'Online payment',
                                                    ]);
                                
                                        
                                      $check =   Monthly_withdrawals::where('month', 'like', '%' . Carbon::now()->format('Y-m') . '%' )->count();
                                      
                                      if($check > 0){
                                            if (app()->getLocale() == 'ar') {
                                                    $msg = 'تهانينا لك دخلت السحب الشهرى';
                                            }else{
                                                    $msg = 'Congratulations, you entered the monthly draw';
                                            }
                                      }else{
                                          if (app()->getLocale() == 'ar') {
                                                      $msg = 'تم الاشتراك بالباقه بنجاح ';
                                              } else {
                                                     $msg = 'Package has been successfully subscribed ';
                                                }
                                      }
                         
                                 return $this->returnData('msg',$msg);
                         
                           
                           }else{
                               
                                      if (app()->getLocale() == 'ar') {
                                              $msg = "هذه الباقه غير موجوده";
                                            } else {
                                             $msg = 'This Package Not Found';
                                      }
                                      
                           }
                     
                       }
                      
          }
         
         }else{
                                if (app()->getLocale() == 'ar') {
                                              $msg = "برجاء ارسال طريقة الدفع ";
                                            } else {
                                             $msg = 'Please Send Payment Method';
                                      }
                                      
                        return $this->returnData('msg',$msg);
         }
   
    }
    

    public function banks(){
        $pacakages=Banks::all();
        $resource=BannksResource::collection($pacakages);
        return $this->returnData('data',$resource);

    }
    
        public function reports($section){
            
            $reports=reports::where('section',$section)->get();
            $resource=reportsResource::collection($reports);
            return $this->returnData('data',$resource);

        }
        
         public function makereport(Request $request){
            
            $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
    
           $rules=[
               'product_id'            =>         'required',
               'section'               =>         'required',
               'report_id'             =>         'required|integer|exists:reports,id',
           ];
           $valdaitor=Validator::make($request->all(),$rules);
           if ($valdaitor->fails()){
               $code=$this->returnCodeAccordingToInput($valdaitor);
               return $this->returnValidationError($code,$valdaitor);
           }
            report_users::create([
                    'product_id'        => $request->product_id,
                    'section'           => $request->section,
                    'report_id'         => $request->report_id,
                    'report_text'       => $request->report_text,
                    'user_id'           => $id,
                ]);
                        if (app()->getLocale() == 'ar') {
                                  $msg = "تم ارسال بلاغك بنجاح";
                          } else {
                              $msg = "Your report has been sent successfully";
                          }
                                      
                        return $this->returnData('msg',$msg);
        }

    public function pymentPlace(){
        $payment=Payment_place::all();
        $resource=PaymentRsource::collection($payment);
        return $this->returnData('data',$resource);
    }

}
