<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\singleAdvResource;
use App\Http\Resources\updateimagesResponse;
use App\Http\Resources\Advertimnets\usercollection;
use App\Advertisments;
use App\Models\Advimages;
use App\Models\appSettings;
use App\Models\appUsers;
use App\Models\area;
use App\Models\Catgories;
use App\Models\Banadv;
use App\Models\Banusers;
use App\Models\Favoritesadv;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\updateadv;
use App\category_item_products;
use App\update_category_item_products;
use App\updateadvimage;
use App\free_advertisments;
class AdvertimnetsController extends Controller
{
    use GeneralTrait;
    use imageTrait;
    
         function __construct() {
             
            $this->checkadvstar();
            $this->currentdate = Carbon::today()->toDateString();
          }
  
     public function show_user_advertimnets($id){
          $all_data = Advertisments::where('user_id',$id)->where('status','!=',0)->where('end_date_in_profile','>=',$this->currentdate)->orderBy('id','DESC')->get();
            if(count($all_data) > 0){
                    $resource=singleAdvResource::collection($all_data);
                    return $this->returnData('advertimnets', $resource);
            }else{
                 return $this->returnData('msg', 'Not Found Data');
            }
            
    }

      
     public function filter_by_area(Request $request){
              $rules = [
                      'place_id' => 'required|integer',
                      'cat_id' => 'required|integer',
         ];
        $valdator = Validator::make($request->all(), $rules);
         if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $all_data = Advertisments::where('place_id',$request->place_id)->where('end_date','>=',$this->currentdate)->where('cat_id',$request->cat_id)->where('status',1)->get();
            // print_r($all_data);die;
            if(count($all_data) > 0){
                     $resource=singleAdvResource::collection($all_data);
                     return $this->returnData('advertimnets', $resource);
            }else{
                 return $this->returnData('msg', 'Not Found Data');
            }
            
        }
          
            
     
    }
    
    public function showall_by_cat(Request $request){
          $rules = [
                      'id' => 'required|integer',
         ];
        $valdator = Validator::make($request->all(), $rules);
         if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            
                $current_date = Carbon::now()->format("Y-m-d");
                
                if(isset($request->search)){
                     $all_data_star = Advertisments::where('status',1)->where('cat_id',$request->id)->where('end_date','>=',$this->currentdate)->Where('name', 'like', '%' . $request->search . '%')->whereNotNull('end_star')->where('end_star','>=',$current_date)->inRandomOrder()->get();
                     $all_data = Advertisments::where('status',1)->where('cat_id',$request->id)->Where('name', 'like', '%' . $request->search . '%')->orderBy('id','DESC')->get();
                }else{
                    if(isset($request->getall)){
                        $cates = Catgories::where('parent_id',$request->id)->get(['id']);
                        $child_cat = [];
                        foreach($cates as $cate){
                            $child_cat[] = $cate->id;
                        }
                        // return $child_cat;
                         $all_data_star = Advertisments::where('status',1)->where('end_date','>=',$this->currentdate)->whereIn('cat_id',$child_cat)->where(function ($query) {
                            $query->where('star', '=', 1)
                                    ->whereNotNull('end_star')
                                  ->Where('end_star', '>=', Carbon::now()->format("Y-m-d"));
                        })->inRandomOrder()->get();
                            
                        $all_data = Advertisments::where('status',1)->where('end_date','>=',$this->currentdate)->whereIn('cat_id',$child_cat)->where(function ($query) {
                                $query->where('star', '=', 0)
                                      ->orWhere('end_star', '<', Carbon::now()->format("Y-m-d"));
                            })->orderBy('id','DESC')->get();
                        
                    }else{
                        
                            $all_data_star = Advertisments::where('status',1)->where('end_date','>=',$this->currentdate)->where('cat_id',$request->id)->where(function ($query) {
                            $query->where('star', '=', 1)
                                        ->whereNotNull('end_star')
                                   ->Where('end_star', '>=', Carbon::now()->format("Y-m-d"));
                              })->inRandomOrder()->get();
                        
                            $all_data = Advertisments::where('status',1)->where('cat_id',$request->id)->where(function ($query) {
                                    $query->where('star', '=', 0)
                                          ->orWhere('end_star', '<', Carbon::now()->format("Y-m-d"));
                                })->orderBy('id','DESC')->get();
                                
                    }
                
                }
        
           
            if(count($all_data) > 0 || count($all_data_star) > 0){
                

                 $resource_star=singleAdvResource::collection($all_data_star);
                 $resource=singleAdvResource::collection($all_data);
                 $values = $resource_star->merge($resource);
                 return $this->returnData('advertimnets', $values);
                  
                  
            }else{
                 return $this->returnData('msg', 'Not Found Data');
            }
         }
    }
    
    public function check_user_count_advertimnets($id){
        
         $freeadv = appUsers::find($id);
         $current_month = Carbon::now()->format('Y-m');
         $check_free_month =free_advertisments::Where('month', 'like', '%' . $current_month . '%')->first();
         $count = $freeadv->adv_number;
         
         if($check_free_month){
            $adv_this_month = Advertisments::withTrashed()->where('user_id',$id)->where('created_at', 'like', '%' . $current_month . '%')->count();
            $count = ($check_free_month->number + $freeadv->adv_number) - $adv_this_month;
         }
         return $this->returnData('count',$count);
    }
   public  function remove_emoji($string) {

        // Match Emoticons
        $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clear_string = preg_replace($regex_emoticons, '', $string);
    
        // Match Miscellaneous Symbols and Pictographs
        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clear_string = preg_replace($regex_symbols, '', $clear_string);
    
        // Match Transport And Map Symbols
        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clear_string = preg_replace($regex_transport, '', $clear_string);
    
        // Match Miscellaneous Symbols
        $regex_misc = '/[\x{2600}-\x{26FF}]/u';
        $clear_string = preg_replace($regex_misc, '', $clear_string);
    
        // Match Dingbats
        $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
        $clear_string = preg_replace($regex_dingbats, '', $clear_string);
    
        return $clear_string;
        }
       public function hasEmoji($string){
            $emojis_regex =
                '/[\x{0080}-\x{02AF}'
                .'\x{0300}-\x{03FF}'
                .'\x{0600}-\x{06FF}'
                .'\x{0C00}-\x{0C7F}'
                .'\x{1DC0}-\x{1DFF}'
                .'\x{1E00}-\x{1EFF}'
                .'\x{2000}-\x{209F}'
                .'\x{20D0}-\x{214F}'
                .'\x{2190}-\x{23FF}'
                .'\x{2460}-\x{25FF}'
                .'\x{2600}-\x{27EF}'
                .'\x{2900}-\x{29FF}'
                .'\x{2B00}-\x{2BFF}'
                .'\x{2C60}-\x{2C7F}'
                .'\x{2E00}-\x{2E7F}'
                .'\x{3000}-\x{303F}'
                .'\x{A490}-\x{A4CF}'
                .'\x{E000}-\x{F8FF}'
                .'\x{FE00}-\x{FE0F}'
                .'\x{FE30}-\x{FE4F}'
                .'\x{1F000}-\x{1F02F}'
                .'\x{1F0A0}-\x{1F0FF}'
                .'\x{1F100}-\x{1F64F}'
                .'\x{1F680}-\x{1F6FF}'
                .'\x{1F910}-\x{1F96B}'
                .'\x{1F980}-\x{1F9E0}]/u';
            preg_match($emojis_regex, $string, $matches);
            return !empty($matches);
        }
    public function create(Request $request){
        
           $rules = [
            'user_id'                   => 'required|integer',
            'imgs'                      => 'required|array',
            'name'                      => 'required|string',
            'whatsapp'                  => 'required',
            'description'               => 'required|string',
            'price'                     => 'sometimes',
            'phone'                     => 'required',
            'place_id'                  => 'required|integer|exists:areas,id',	
            'cat_id'                    => 'required|integer|exists:catgories,id',
            // 'filter_id'                 => 'required|array',
        ];
        $valdator = Validator::make($request->all(), $rules);
         if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } 
        
            $examination_certificate = Catgories::find($request->cat_id);
            if($examination_certificate){
                if($examination_certificate->examination_image == 1){
                      $rules = [
                            'examination_certificate'   => 'required|file',
                        ];
                         $valdator = Validator::make($request->all(), $rules);
                         if ($valdator->fails()) {
                            $code = $this->returnCodeAccordingToInput($valdator);
                            return $this->returnValidationError($code, $valdator);
                        } 
                }
            }
          
            $appSettings = appSettings::first();
            $User = appUsers::find($request->user_id);
            // $user_count_advertisments = Advertisments::withTrashed()->where('user_id',$request->user_id)->count();
            
             $current_month = Carbon::now()->format('Y-m');
             $check_free_month =free_advertisments::Where('month', 'like', '%' . $current_month . '%')->first();
             $count = $User->adv_number;
             
             if($check_free_month){
                $adv_this_month = Advertisments::withTrashed()->where('user_id',$request->user_id)->where('created_at', 'like', '%' . $current_month . '%')->count();
                $count = ($check_free_month->number + $User->adv_number) - $adv_this_month;
             }
                     
            if($count < 1){
                    return $this->returnData('msg', 'User has passed the number of free ads');
            }else{
                
                //  $description =  $this->remove_emoji($request->description);
                // $check =  $this->hasEmoji($request->description);
                // if($check){
                    
                //         if (app()->getLocale() == 'ar') {
                //             return $this->returnData('status',false, 'برجاء كتابة نص صحيح');
                //         } else {
                //           return $this->returnData('status',false, 'Please enter valid text');
                //         }
                // }
                $examination = '';
                 if(isset($request->examination_certificate)){
                        $examination = $this->storeImages($request->examination_certificate, $this->main_path().'uploads/advexamination_certificate/');
                 }else{
                     $examination == NULL;
                 }
                $advertisments = Advertisments::create([
                    'user_id'                           => $request->user_id,
                    'name'                              => $request->name,
                    'description'                       => $request->description,
                    'whatsapp'                          => $request->whatsapp,
                    'price'                             => $request->price,
                    'phone'                             => $request->phone,
                    'place_id'                          => $request->place_id,
                    'cat_id'                            => $request->cat_id,
                    'examination_certificate'           => $examination,
                 ]);//create user
            
                
                if(!empty($request->filter_id)){
                    
                         for($i=0;$i<count($request->filter_id);$i++){
                                    $text = NULL;
                                    $sub_filter_id = NULL;
                                if(!empty($request->text)){
                                    if (array_key_exists($i,  $request->text)) {
                                        $text = $request->text[$i]; 
                                    }
                                }
                                
                                if (array_key_exists($i,  $request->sub_filter_id)) {
                                    $sub_filter_id = $request->sub_filter_id[$i]; 
                                }
                                category_item_products::create([
                                        'category_item_id'                  => $request->filter_id[$i],
                                        'category_item_component_id'        => $sub_filter_id,
                                        'text'                              => $text ,
                                        'product_id'                        => $advertisments->id,
                                        'type'                              => 0,
                                    ]);
                            }
                            
                }
           
                
                
               foreach($request->imgs as $img){
                       $imageName = $this->storeImages($img, $this->main_path().'uploads/advimage/');
                       Advimages::create([
                        'img' => $imageName,
                        'adv_id' => $advertisments->id,
                        
                    ]);

                 }
                 
                     
        
        // -------------------------------------------------------------------------
              
                 if($check_free_month){
                    if($adv_this_month > $check_free_month->number){
                         $User->update(['adv_number'=>$User->adv_number-- ]);
                    }
                 }else{
                     $User->update(['adv_number'=>$User->adv_number-- ]);
                 }
                 
        // ------------------------------------------------------------------------------
                if(app()->getLocale() == 'ar'){
                     $msg = $appSettings->after_adv_ar;
                }else{
                     $msg = $appSettings->after_adv_en;
                }
                
              
                
                $data = Advertisments::find($advertisments->id);
                $resource=new usercollection($data);

                return $this->returnData('advertimnets', $resource  ,$msg );
            }
            
        
}



   public function show(Request $request){
        
            $data = Advertisments::find($request->id);
            if($data){
                    $resource=new usercollection($data);
                    return $this->returnData('advertimnets', $resource);
            }else{
                    return $this->returnData('msg', 'Not Found Data');
            }
    
        
    }
    
    
    public function showall(){
        
            $all_data = Advertisments::where('status',1)->where('end_date','>=',$this->currentdate)->get();
             if(count($all_data) > 0){
                  $resource=singleAdvResource::collection($all_data);
                return $this->returnData('advertimnets', $values);
             }else{
                 return $this->returnData('msg', 'Not Found Data');
            }
        
    }

    public function update(Request $request){
       
       $data = Advertisments::find($request->id);
       if(!$data){
            if (app()->getLocale() == 'ar') {
                 return $this->returnData('status',false, 'هذا الاعلان غير موجود');
              } else {
                   return $this->returnData('status',false, 'This Advertisment Not Found ');
                }
       }else{
             $rules = [
            'name'                      => 'required|string',
            'description'               => 'required|string',
            'price'                     => 'required',
            'phone'                     => 'required',
            'place_id'                  => 'required|integer|exists:areas,id',
            'cat_id'                    => 'required|integer|exists:catgories,id',
            'whatsapp'                  => 'sometimes',
        ];
        
        $valdator = Validator::make($request->all(), $rules);
         if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
          
      
                if(isset($request->examination_certificate)){
                     $examination_certificate = $this->storeImages($request->examination_certificate, $this->main_path().'uploads/advexamination_certificate/');
                     
                }else{
                    $examination_certificate = NULL;
                } 
                $data->examination_certificate = $examination_certificate;
            $advertisments = updateadv::create([
                        'adv_id'                            => $request->id,
                        'name'                              => $request->name,
                        'description'                       => $request->description,
                        'price'                             => $request->price,
                        'phone'                             => $request->phone,
                        'place_id'                          => $request->place_id,
                        'cat_id'                            => $request->cat_id,
                        'whatsapp'                          => $request->whatsapp,
                        'examination_certificate'           => $examination_certificate,
            ]);
            
            
            
              for($i=0;$i<count($request->filter_id);$i++){
                        $text = NULL;
                        $sub_filter_id = NULL;
                         if(!empty($request->text)){
                            if (array_key_exists($i,  $request->text)) {
                                $text = $request->text[$i]; 
                            }
                         }
                    if (array_key_exists($i,  $request->sub_filter_id)) {
                        $sub_filter_id = $request->sub_filter_id[$i]; 
                    }
                    update_category_item_products::create([
                            'category_item_id'                  => $request->filter_id[$i],
                            'category_item_component_id'        => $sub_filter_id,
                            'text'                              => $text ,
                            'product_id'                        => $request->id,
                            'type'                              => 0,
                        ]);
                }
                
                
                
                
                if(isset($request->imgs)){
                            //  $image=Advimages::where('adv_id',$request->id)->delete();  
                             foreach($request->imgs as $img){
                                      $imageName = $this->storeImages($img, $this->main_path().'uploads/advimage/');
                                      updateadvimage::create([
                                        'img' => $imageName,
                                        'adv_id' => $request->id,
                                    ]);
                                    $images[] =asset('uploads/advimage/'.$imageName);
                                 }
                          $data->images = $images;
                
                    }
                $data->images = updateadvimage::where("adv_id" , $request->id)->where("status" , 0)->get();
                $resource=new singleAdvResource($data);
                
                    if (app()->getLocale()=='ar'){
                            $msg = 'شكرًا لك . في انتظار موافقة المسؤول';
                      }else{
                           $msg = 'Thank you . Waiting for admin approval';
                      }
                  
                    
                return $this->returnData('advertimnets', $resource , $msg);
            
            
        } 
       }
        

    }

    public function addImages(Request $request){
          $rules=[
              'adv_id'          =>         'required',
              'imgs'            =>         'required',
          ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $imagesnames=[];
            foreach ($request->file('imgs') as $single) {
                $imgname = $this->storeImages($single, 'uploads/adverisments/');
                $imges = new Advimages();
                $imges->img = $imgname;
                $imges->adv_id = $request->adv_id;
                $imges->save();
                array_push($imagesnames,$imges);
            }
            $imagecollescts=collect($imagesnames);
            $resource=updateimagesResponse::collection($imagecollescts);
            return $this->returnData('data',$resource);

        }


    }


    public function deleteimage(Request $request){
        $rules=[
            'img_id'          =>         'required',
        ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
             $image=Advimages::destroy($request->img_id);  
              if ($image){
                  if (app()->getLocale()=='ar'){
                      return $this->returnSuccessMessage('تم الحذف بنجاح');
                  }else{
                      return $this->returnSuccessMessage('Deleted Successfully');
                  }
              }

        }
    }


    public function deleteadv($id){
            $destroy=Advertisments::destroy($id);
            if (app()->getLocale()=='ar'){
                 return $this->returnSuccessMessage('تم حذف الاعلان بنجاح');
            }else{
                return $this->returnSuccessMessage(' Adv delete successflly');
            }

        }


    public function banadv(Request $request){

        $rules = [
            'adv_id' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $user_id =$this->getUserID($request->bearerToken());
            $owner_id=DB::table('advertisments')->where('id',$request->adv_id)->value('user_id');

            $parma = ['user_id' =>$user_id, 'adv_id' => $request->adv_id];
            $query =Banadv::updateOrCreate($parma, ['status' => 1]);
            if ($query) {
                $banuser=Banusers::updateOrCreate([
                    'user_id'        =>      $user_id,
                    'second_user'    =>      $owner_id,
                    'status'         =>      1,

                ]);
                if (app()->getLocale() == 'ar') {
                    return $this->returnSuccessMessage('تم الحظر بنجاح');
                } else {
                    return $this->returnSuccessMessage('Baned Successfully');
                }
            }
        }

    }

    public function addtoremovefav(Request $request){
        $user_id =$this->getUserID($request->bearerToken());
        $rules = [
            'adv_id' => 'required',
            'status' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {

            $parma = ['user_id' => $user_id, 'adv_id' => $request->adv_id];
            $query = Favoritesadv::updateOrCreate($parma, ['status' => $request->status]);
            if ($query) {
                if (app()->getLocale() == 'ar') {
                    return $this->returnSuccessMessage('تم الحفظ بنجاح');
                } else {
                    return $this->returnSuccessMessage('Saved Successfully');
                }
            }
        }
    }

    public function singleAdv(Request $request){

        $rules = [
            'add_id' => 'required|exists:advertisments,id',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $id=$this->getUserIDNOt($request->bearerToken());
            $single=Advertisments::find($request->add_id);
            $single->check_id=$id;
            $resource=new singleAdvResource($single);
            return $this->returnData('data',$resource);
        }

    }

    public function search(Request $request){

        $rules = [
            'keyword' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {

            $adv= Advertisments::where('title', 'like', "%$request->keyword%")->latest()->get();
            $recomended=alladvertismetsResource::collection($adv);
            return $this->returnData('data',$recomended);
        }
    }
    public function checkadvstar(){
        
            $all = Advertisments::where('star' , 1)->get();
            
            foreach($all as $item){
                
                      $adv= Advertisments::find($item->id);
                      if($adv->star == 1 && $adv->end_star != NULL){
                          if(Carbon::now() > $adv->end_star ){
                              $adv->update(['star'=>0]);
                          }
                      }
            
            
            }
    }
    
    
       public function filtration(Request $request){
         
                $current_date = Carbon::now()->format("Y-m-d");
                
                $all_data_star = Advertisments::where('status',1)->where('end_date','>=',$this->currentdate)->whereNotNull('end_star')->where('end_star','>=',$current_date);
                $all_data = Advertisments::where('status',1)->where('end_date','>=',$this->currentdate)->where(function($q) use ($current_date) {
                  $q->where('end_star','<',$current_date)
                    ->orWhereNull('end_star');
                });
                
               
              
                    // if ($request->has('search')){
                    //         $all_data_star->Where('name', 'like', '%' . $request->search . '%')->where('end_star','>=',$current_date)->orderBy('id','DESC');
                    //         $all_data->Where('name', 'like', '%' . $request->search . '%');
                    // }
                   
                   
                 
                    if ($request->has('cat')){
                        $cates = Catgories::where('parent_id',$request->cat)->get(['id']);
                        $child_cat = [];
                        foreach($cates as $cate){
                            $child_cat[] = $cate->id;
                        }
                      $dat['child'] = $child_cat;
                      $dat['cat'] = $request->cat;
                       $all_data_star->where(function ($q) use ( $dat) {
                                  $q->whereIn('cat_id',$dat['child'])
                                    ->orwhere('cat_id',$dat['cat']);
                                });
                       $all_data->where(function ($q) use ($dat) {
                                  $q->whereIn('cat_id',$dat['child'])
                                    ->orwhere('cat_id',$dat['cat']);
                                });
                    }
                   
                   
                   if ($request->has('area')){
                       $all_data_star->where('place_id',$request->area);
                       $all_data->where('place_id',$request->area);
                   }
                   
                   if ($request->has('filter_id')){

                       $products = category_item_products::where('type',0)->whereIn('category_item_id',$request->filter_id)->pluck('product_id')->toArray();
                       
                       $all_data_star->WhereIn('id',$products);
                       $all_data->WhereIn('id',$products);
                    
                   }
                   
                   
                    if ($request->has('sub_filter_id')){
                        
                       $products = [];
                       $products = category_item_products::where('type',0)->whereIn('category_item_component_id',$request->sub_filter_id)->pluck('product_id')->toArray();
                       
                     
                       $all_data_star->WhereIn('id',$products);
                       $all_data->WhereIn('id',$products);
                       
                        
                   }
                   
                   if ($request->has('text')){
                       $products = [];
                      
                       foreach($request->text as $text){
                          
                            $products[] = category_item_products:: where('type',0)->where('text', 'like', '%'.$text.'%')->pluck('product_id')->toArray();
                           
                       }
                      
                       $all_data_star->WhereIn('id',$products);
                       $all_data->WhereIn('id',$products);
                   }

                $all_data_star  =  $all_data_star->inRandomOrder()->get();
                $all_data       =  $all_data->orderBy('id','DESC')->get();
                
               
            if(count($all_data) > 0 || count($all_data_star) > 0){
                

                 $resource_star=singleAdvResource::collection($all_data_star);
                 $resource=singleAdvResource::collection($all_data);
                 $values = $resource_star->merge($resource);
                 return $this->returnData('advertimnets', $values);
                  
                  
            }else{
                 return $this->returnData('msg', 'Not Found Data');
            }
         }
    
    
       public function repost(Request $request , $adv_id){
           
            
               $token = $request->bearerToken();
                $id = $this->getUserID($token);  
                if(!is_numeric($id)){
                    return $id;
                }
        
                
                
                    $appSettings = appSettings::first();
                    $User = appUsers::find($id);
                    $current_month = Carbon::now()->format('Y-m');
                     $check_free_month =free_advertisments::Where('month', 'like', '%' . $current_month . '%')->first();
                     $count = $User->adv_number;
                     
                     if($check_free_month){
                        $adv_this_month = Advertisments::withTrashed()->where('user_id',$id)->where('created_at', 'like', '%' . $current_month . '%')->count();
                        $count = ($check_free_month->number + $User->adv_number) - $adv_this_month;
                     }
             
                    if($count < 1){
                            return $this->returnData('msg', 'User has passed the number of free ads');
                    }
                    
                    $adv = Advertisments::find($adv_id);
                    if($adv->end_date == NULL && $adv->status == 0){
                        return $this->returnData('msg', 'Please wait for admin approval');
                    }
                    if($adv){
                        $adv->update([
                            'end_date'=>NULL,
                            'status'=>0,
                        ]);
                        
                             
                                // -------------------------------------------------------------------------
                                      
                                         if($check_free_month){
                                            if($adv_this_month > $check_free_month->number){
                                                 $User->update(['adv_number'=>$User->adv_number-- ]);
                                            }
                                         }else{
                                             $User->update(['adv_number'=>$User->adv_number-- ]);
                                         }
                                         
                                // ------------------------------------------------------------------------------
                                                    
                            if(app()->getLocale() == 'ar'){
                                 $msg = $appSettings->after_adv_ar;
                            }else{
                                 $msg = $appSettings->after_adv_en;
                            }
            
                            return $this->returnData('msg',$msg);
                    }
                    
                     return $this->returnData('msg', 'Not Found Advertisment');
       }
    
    
    

}
