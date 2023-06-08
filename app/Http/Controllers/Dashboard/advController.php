<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\advertiseComeents;
use App\Advertisments;
use App\Models\Advimages;
use App\Models\advretisements;

use App\Models\area;
use App\Models\Catgories;
use App\Models\appSettings;
use App\Models\appUsers;
use App\Models\banAdvertisment;
use App\Models\Packages;
use App\Models\User_Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\updateadvimage;
use App\updateadv;
use App\category_item_products;
use App\update_category_item_products;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use App\Traits\notifcationTrait;
use App\Notifications;
use App\category_item_components;
use App\category_items;
class advController extends Controller
{
    use GeneralTrait;
     use imageTrait;
     use notifcationTrait;
  public function index(){
      
            abort_if(!auth()->user()->hasPermission('read_advertiments'), 403);
      
      
           $all_data = Advertisments::orderBy('created_at', 'desc')->with('images')->get();
           $advertisments = [];
               foreach( $all_data as $data){
                        $imageData = [];
                      foreach($data->images as $image){
                          $imageData[] = asset('uploads/advimage/'.$image->img);
                          
                      }
                     
                      $checkarea = area::find($data->place_id);
                      if($checkarea){
                            $data->place =$checkarea->name;
                      }else{
                           $data->place = 'لا يوجد منطقه';
                      }
                      
                       $checkCatgories = Catgories::find($data->cat_id);
                      if($checkCatgories){
                          $data->cat = $checkCatgories->name;
                      }else{
                           $data->cat = 'لا يوجد قسم';
                      }
                 
                    
                    $checkuser = appUsers::find($data->user_id);
                     if($checkuser){
                              $data->user = $checkuser->name;
                      }else{
                              $data->user = 'Not Found User';
                      }
                unset ($data->images);
                unset( $data->place_id);
                unset( $data->cat_id);
                unset ($data->user_id);
                $data->imgs = $imageData;
                    
                    $advertisments[] =   $data;
                    
            }
            return view('dashboard.advertismnets.index', compact('advertisments'));
            
    }
    
    
    
    // -----------------------------------------------------------------------------------------------------------
    
    
      public function update_requirements(){
          
            abort_if(!auth()->user()->hasPermission('update_adv_requirment'), 403);
            
           $all_data = updateadv::where('status' , 0)->get();
           $advertisments = [];
               foreach( $all_data as $data){
                    $mainAdvertisments = Advertisments::find($data->adv_id);
                
                    if($mainAdvertisments){
                          $data->user = appUsers::find($mainAdvertisments->user_id)->name;
                    }
          
                      $checkarea = area::find($data->place_id);
                      if($checkarea){
                            $data->place = $checkarea->name;
                      }else{
                           $data->place = 'لا يوجد منطقه';
                      }
                      
                       $checkCatgories = Catgories::find($data->place_id);
                      if($checkCatgories){
                          $data->cat = $checkCatgories->name;
                      }else{
                           $data->cat = 'لا يوجد قسم';
                      }
                          
                
              
                unset( $data->place_id);
                unset( $data->cat_id);
                // $data->imgs = $imageData;
                
                $advertisments[] =   $data;
                    
            }
            return view('dashboard.advertismnets.updated-requierments', compact('advertisments'));
            
    }
    
    public function update_requirements_change_status($id , $status){
        
         abort_if(!auth()->user()->hasPermission('update_adv_requirment'), 403);
         
         $adv = updateadv::find($id);
         $images = updateadvimage::where("adv_id" , $adv->adv_id)->where("status" , 0)->get();
         $filters= update_category_item_products::where("product_id" , $adv->adv_id)->where("type" , 0)->where("status" , 0)->get();
        if($status == 0){
           
            $adv->update(['status'=>2]);
            
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.update_adv_requirements');
        }elseif($status == 1){
            $mainadv = Advertisments::find($adv->adv_id);
            
            if(!empty($adv->examination_certificate)){
                
                    if (!empty($mainadv->advexamination_certificate) && file_exists($this->main_path().'uploads/advexamination_certificate/'.$mainadv->advexamination_certificate)) {
                         unlink($this->main_path().'uploads/advexamination_certificate/'.$mainadv->advexamination_certificate);
                    }
                    
                   
                    $mainadv->update(['examination_certificate' => $adv->examination_certificate]);
                    
            }
            // return (count($images) );
            
            $mainadv->update([
                'name' => $adv->name,
                'description' => $adv->description,
                'price' => $adv->price,
                'phone' => $adv->phone,
                'place_id' => $adv->place_id,
                'cat_id' => $adv->cat_id,
                'whatsapp' => $adv->whatsapp,
            ]);
            //  return $mainadv;
            if(count($images) > 0){
                                $old = Advimages::where('adv_id' ,  $adv->adv_id)->get();
                                foreach($old as $ol){
                                      if (file_exists($this->main_path().'uploads/advimage/'.$ol->img)) {
                                             unlink($this->main_path().'uploads/advimage/'.$ol->img);
                                        }   
                                    
                                          $ol->delete();
                                }
                        
                                foreach($images as  $img){
                                    Advimages::create([
                                    'img' => $img->img,
                                    'adv_id' =>  $adv->adv_id,
                                    ]);
                                    
                                    $img->update(['status'=>1]);
                            }
            }
            
            if(count($filters) > 0){
                category_item_products::where('product_id' ,  $adv->adv_id)->where('type' ,  0)->delete();
                foreach($filters as $filter){
                    category_item_products::create([
                            'category_item_id'                  => $filter->category_item_id,
                            'category_item_component_id'        => $filter->category_item_component_id,
                            'text'                              => $filter->text,
                            'product_id'                        => $adv->adv_id,
                            'type'                              => 0,
                        ]);
                        
                     $filter->update(['status'=>1]);
                }
            }
              $adv->update(['status'=>1]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.update_adv_requirements');
        }
    }


    public function create($user_id){
         abort_if(!auth()->user()->hasPermission('create_advertiments'), 403);
         
        $areas = area::get();
        $categores = Catgories::where('parent_id',1)->get();
        return view('dashboard.advertismnets.add', compact('user_id','categores','areas'));
    }
    
        public function get_filters(Request $request){
         abort_if(!auth()->user()->hasPermission('create_advertiments'), 403);
         
        $filters = category_items::where('cat_id',$request->cat_id)->wherenull('parent_category_items')->get();
        return view('dashboard.advertismnets.filters', compact('filters'));
    }
    
        public function get_child(Request $request){
            
             abort_if(!auth()->user()->hasPermission('create_advertiments'), 403);
             
            $filter_id = $request->filter_id;
            $componant = $request->componant;
             $main = category_items::find($filter_id);
           
            $filters = category_items::where('parent_category_items',$filter_id)->get();
             if($main && $filters->count() > 0){
              
                  
                         return view('dashboard.advertismnets.filter-child', compact('filters','componant'));
                    
                   
            }
            return '';
    }

    public function store(Request $request)
    {
       abort_if(!auth()->user()->hasPermission('create_advertiments'), 403);
       
                    $setting  = appSettings::first(['ad_duration','ad_duration_profile']);
                    $end_date = Carbon::now()->addDays($setting->ad_duration);

                    $end_date_profile = Carbon::parse($end_date)->addDays($setting->ad_duration_profile);
                                
                     $examination = null;
                    if(isset($request->examination_certificate)){
                            $examination = $this->storeImages($request->examination_certificate, $this->main_path().'uploads/advexamination_certificate/');
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
                        'status'                            => 1,
                        'end_date'                          => $end_date,
                        'end_date_in_profile'               => $end_date_profile,
                        'whatsapp'                          => $request->whatsapp,
                 ]);//create user
           
                
                for($i=0;$i< count($request->filters_id);$i++){
                    if($request->types[$i] == 3){            // text
                    
                         category_item_products::create([
                            'category_item_id'                  => $request->filters_id[$i],
                            'category_item_component_id'        => $request->sub_filter_id[$i],
                            'text'                              => $request->text[$request->sub_filter_id[$i]],
                            'product_id'                        => $advertisments->id,
                            'type'                              => 0,
                        ]);
                    }elseif($request->types[$i] == 1){           // single
                    
                           category_item_products::create([
                            'category_item_id'                  => $request->filters_id[$i],
                            'category_item_component_id'        => $request->sub_filter_id[$i],
                            'product_id'                        => $advertisments->id,
                            'type'                              => 0,
                        ]);
                        
                    }
                    
                   
                }
                
                  for($i=0;$i< count($request->multi_filters_id);$i++){
                  
                        
                        for($j=0; $j < count($request->multi_sub_filter_id[$request->multi_filters_id[$i]]);$j++){
                             category_item_products::create([
                                'category_item_id'                  => $request->multi_filters_id[$i],
                                'category_item_component_id'        => $request->multi_sub_filter_id[$request->multi_filters_id[$i]][$j],
                                'product_id'                        => $advertisments->id,
                                'type'                              => 0,
                            ]);
                        }
                        
                    
                    
                   
                }
                
               foreach($request->images as $img){
                       $imageName = $this->storeImages($img, $this->main_path().'uploads/advimage/');
                       Advimages::create([
                        'img' => $imageName,
                        'adv_id' => $advertisments->id,
                        
                    ]);
                    $images[] =asset('uploads/advimage/'.$imageName);
                  
                 }
                 
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->route('dashboard.advertismnets.index');
                 
    }


     
     public function  change_status( $id , $status){
        
         abort_if(!auth()->user()->hasPermission('active_advertiments'), 403);
         
         
         $mainadv = Advertisments::find($id);
         if($status == 5){
             $mainadv->delete();
             
            $images =  Advimages::where('adv_id' ,  $id)->get();
            foreach($images as $img){
                  unlink('laytwfk/public/uploads/advimage/'.$img->img);
            }
            
              Advimages::where('adv_id' ,  $id)->delete();
         }else{
                
                if(empty($mainadv->end_date) && $status == 1){
                    $setting  = appSettings::first(['ad_duration','ad_duration_profile']);
                    $end_date = Carbon::now()->addDays($setting->ad_duration);
                    
                    $end_date_profile = Carbon::parse($end_date)->addDays($setting->ad_duration_profile);
                    $mainadv->update([
                                'end_date'=>$end_date,
                                'end_date_in_profile'=>$end_date_profile,
                                ]);
                                
                      $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$mainadv->user_id)->value('token'); 
                                      
                
                        $msg_en = "Your ad has been accepted";
                        $msg_ar = "تم قبول نشر الاعلان الخاص بكم" ;
                        $msg = ['ar' => $msg_ar , 'en' => $msg_en][app()->getLocale()];
                        
                            if(!empty($fcmtoken)){
                                $this->pushNotification([  
                                    'order_id' => null,
                                    'title'=> 'lay6ofk' ,
                                    'body'=> $msg,
                                    'click_action'=> "ACTION_NORMAL" ,
                                    'device_token' => [$fcmtoken],
                                    'id'=> 0,
                                    'type'=>'auction'
                                ]);
                            } 
                                Notifications::create([
                                    'msg'=> $msg,
                                    'title'=> 'lay6ofk',
                                    'user_id'=> $mainadv->user_id,
                                    'product_id'=> $id,
                                    'type' => 2
                             ]);
                        
                }
                
                            
                      
            
                $mainadv->update(['status'=>$status]);
         }
       
            session()->flash('success', __('site.updated_successfully'));
           return redirect()->route('dashboard.advertismnets.index');
    }
    

    public function show($advretisements)
    {
         abort_if(!auth()->user()->hasPermission('read_advertiments'), 403);
        $status=DB::table('advertisments')->where('id',$advretisements)->value('active');
        if ($status==1){
            $about=DB::table('advertisments')->where('id',$advretisements)->update(['active'=>0]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.advertismnets.index');
        }else{
            $about=DB::table('advertisments')->where('id',$advretisements)->update(['active'=>1]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.advertismnets.index');
        }
    }
    
    
    
    public function show_adv($id , $type = 0){
        abort_if(!auth()->user()->hasPermission('read_advertiments'), 403);
        
        
        if($type == 0){         // nourmal tables
             $advertisments = Advertisments::find($id);
             $images = Advimages::where("adv_id" ,$id)->get();
             $filters = category_item_products::where('product_id',$id)->where('type',0)->get();
        }else{             // requirement update adv
             $advertisments = updateadv::where('adv_id',$id)->where('status',0)->first();
             $images =  updateadvimage::where("adv_id" , $id)->where("status" , 0)->get();
             $filters = update_category_item_products::where('product_id',$id)->where('type',0)->where('status',0)->get();
        }
        
          $categores = Catgories::find($advertisments->cat_id);
          $areas = area::find($advertisments->place_id);
        
          return view('dashboard.advertismnets.Advertimnet-details',compact('advertisments','images','filters','categores','areas'));
    }
    

    public function edit($advretisements)
    {
         abort_if(!auth()->user()->hasPermission('update_advertiments'), 403);
         
         
        $iamges=Advimages::all()->where('adv_id','=',$advretisements);
        return view('dashboard.advertismnets.index2',compact('iamges'));
    }
    
    
    
      public function ad_duration(){
           abort_if(!auth()->user()->hasPermission('ad_duration'), 403);
           
           
        $data=appSettings::first(['ad_duration','ad_duration_profile']);
        return view('dashboard.advertismnets.ad_duration',compact('data'));
    }
    
     public function ad_duration_update(Request $request){
         
           abort_if(!auth()->user()->hasPermission('ad_duration'), 403);
           
           
                appSettings::first()->update([
                                    'ad_duration'           =>$request->ad_duration,
                                    'ad_duration_profile'   =>$request->ad_duration_profile,
                                ]);
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->back();
    }


     public function editadv($id){
         
          abort_if(!auth()->user()->hasPermission('update_advertiments'), 403);
          
          
         $data = Advertisments::find($id);
         if(!$data){
              return redirect()->route('dashboard.advertismnets.index');
         }
           
                   
                         $data->place = area::find($data->place_id);
                         if($data->place){
                             $data->place = $data->place->name;
                         }else{
                             $data->place = 'Not Found Area';
                         }
                         
                         $data->cat = Catgories::find($data->cat_id);
                         $main_categorys = Catgories::where('parent_id',1)->get();
                         $parent_id = 0;
                         if($data->cat){
                               $categores = Catgories::where('parent_id',$data->cat->parent_id)->get();
                               $parent_id = $data->cat->parent_id;
                               $data->cat = $data->cat->name;
                               
                         }
                            
                    $data->images = Advimages::where("adv_id" , $data->id)->get();
                    $areas = area::get();
                     $advertisments =   $data;
                    //  return $advertisments;
                     $filters = category_items::where('cat_id',$parent_id)->wherenull('parent_category_items')->get();
                    return view('dashboard.advertismnets.edit', compact('advertisments' , 'main_categorys' ,'parent_id', "categores","areas",'filters'));
     }
     
         public function editadv_requierments($id){
             
             abort_if(!auth()->user()->hasPermission('update_adv_requirment'), 403);
             
                         $data = updateadv::find($id);
                         if(!$data){
                              return redirect()->back();
                         }
                        
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                    $categores = Catgories::where('parent_id',$data->cat->parent_id)->get();
                                    $data->cat = $data->cat->name_en;
                                 }else{
                                        $categores = Catgories::where("parent_id" , 1)->get();
                                        $data->cat = 'Not Found Category';
                                 }
                                 
                        $data->images = updateadvimage::where("adv_id" , $data->adv_id)->where("status" , 0)->get();
                        $areas = area::get();
                        $advertisments =   $data;
                        
                    return view('dashboard.advertismnets.edit-requierments', compact('advertisments' , "categores","areas"));
     }
     
      public function updateadv(Request $request , $id){
       
         abort_if(!auth()->user()->hasPermission('update_advertiments'), 403);
         
         
       $advertisments = Advertisments::find($id);
       if(!$advertisments){
             return redirect()->back();
       }else{
              $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string|min:10',
                    'price' => 'required|numeric',
                    'phone' => 'required|numeric|min:11',
                    'place_id' => 'required|integer',
                    'cat_id' => 'required|integer',
            ]);
        
     
          
                    $examination = null;
                    if(isset($request->examination_certificate)){
                        if(!empty($advertisments->examination_certificate)){
                             if (file_exists('laytwfk/public/uploads/advexamination_certificate/'.$advertisments->examination_certificate)) {
                                unlink('laytwfk/public/uploads/advexamination_certificate/'.$advertisments->examination_certificate);
                            } 
                        }
                      
                            $examination = $this->storeImages($request->examination_certificate, $this->main_path().'uploads/advexamination_certificate/');
                             $advertisments->update([
                                    'examination_certificate' => $examination,
                                ]);
                        
                    }
      
                
                 $advertisments->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'price' => $request->price,
                        'phone' => $request->phone,
                        'place_id' => $request->place_id,
                        'cat_id' => $request->cat_id,
                        'whatsapp' => $request->whatsapp,

            ]);
            
                    category_item_products::where('product_id',$advertisments->id)->where('type',0)->delete();
               
                    for($i=0;$i< count($request->filters_id);$i++){
                    if($request->types[$i] == 3){            // text
                    
                         category_item_products::create([
                            'category_item_id'                  => $request->filters_id[$i],
                            'category_item_component_id'        => $request->sub_filter_id[$i],
                            'text'                              => $request->text[$request->sub_filter_id[$i]],
                            'product_id'                        => $advertisments->id,
                            'type'                              => 0,
                        ]);
                    }elseif($request->types[$i] == 1){           // single
                    
                           category_item_products::create([
                            'category_item_id'                  => $request->filters_id[$i],
                            'category_item_component_id'        => $request->sub_filter_id[$i],
                            'product_id'                        => $advertisments->id,
                            'type'                              => 0,
                        ]);
                        
                    }
                    
                   
                }
                
                  for($i=0;$i< count($request->multi_filters_id);$i++){
                  
                        
                        for($j=0; $j < count($request->multi_sub_filter_id[$request->multi_filters_id[$i]]);$j++){
                             category_item_products::create([
                                'category_item_id'                  => $request->multi_filters_id[$i],
                                'category_item_component_id'        => $request->multi_sub_filter_id[$request->multi_filters_id[$i]][$j],
                                'product_id'                        => $advertisments->id,
                                'type'                              => 0,
                            ]);
                        }
                        
                    
                    
                   
                }
          

                if(!empty($request->file('images'))){
                    
                             foreach($request->file('images') as $img){
                                      $imageName = $this->storeImages($img, 'laytwfk/public/uploads/advimage/');
                                             Advimages::create([
                                        'img' => $imageName,
                                        'adv_id' => $advertisments->id,
                                        
                                    ]);
                                    $images[] =asset('uploads/advimage/'.$imageName);
                                  
                                 }

                    }
                   

            session()->flash('success', __('site.updated_successfully'));
           return redirect()->route('dashboard.advertismnets.index');
        
       }
        

    }
        public function advertisments_update_requierments(Request $request , $id){
       
        abort_if(!auth()->user()->hasPermission('update_adv_requirment'), 403);
        
       $advertisments = updateadv::find($id);
       if(!$advertisments){
             return redirect()->back();
       }else{
              $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string|min:10',
                    'price' => 'required|numeric',
                    'phone' => 'required|numeric|min:11',
                    'place_id' => 'required|integer',
                    'cat_id' => 'required|integer',
            ]);
        
     
          
      
                
                 $advertisments->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'price' => $request->price,
                        'phone' => $request->phone,
                        'place_id' => $request->place_id,
                        'cat_id' => $request->cat_id,
                        'whatsapp' => $request->whatsapp,

            ]);//create user
            
               
          

                if(!empty($request->file('images'))){
                    
                             foreach($request->file('images') as $img){
                                      $imageName = $this->storeImages($img, 'laytwfk/public/uploads/advimage/');
                                             updateadvimage::create([
                                                'img' => $imageName,
                                                'adv_id' => $advertisments->adv_id,
                                        
                                    ]);
                                    $images[] =asset('uploads/advimage/'.$imageName);
                                  
                                 }

                    }
                   

            session()->flash('success', __('site.updated_successfully'));
           return redirect()->route('dashboard.update_adv_requirements');
        
       }
        

    }
    
        public function delete_image(Request $request){
          abort_if(!auth()->user()->hasPermission('update_advertiments'), 403);
          
        $image =  Advimages::find($request->id);
        unlink('laytwfk/public/uploads/advimage/'.$image->img);
        $image->delete();  
    }
    
     
        public function delete_image_requierments(Request $request){
         abort_if(!auth()->user()->hasPermission('update_adv_requirment'), 403);
         
        $image =  updateadvimage::find($request->id);
        unlink('laytwfk/public/uploads/advimage/'.$image->img);
        $image->delete();  
    }

    public function destroy($advretisements)
    {
          abort_if(!auth()->user()->hasPermission('delete_advertiments'), 403);
          
        $del=Advertisments::destroy($advretisements);

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.advertismnets.index');
    }




}
