<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auctions;
use App\AuctionImages;
use App\Models\appUsers;
use App\Models\area;
use App\Models\Catgories;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use App\Models\appSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\auction_users;
use App\Traits\notifcationTrait;
use App\Notifications;
use App\category_item_products;
class AuctionsController extends Controller
{
     use GeneralTrait;
     use imageTrait;
      use notifcationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(!auth()->user()->hasPermission('read_auctions'), 403);
         
           $all_data = Auctions::orderBy('created_at', 'desc')->get();
           $auctions = [];
            foreach( $all_data as $data){
                 
                    $imageData = [];
                      foreach( $data->images as $image){
                          $imageData[] = asset('uploads/auctions/'.$image->img);
                        //   break;  // get only one image
                          
                }
                 if (app()->getLocale() == 'ar') {
                              $data->place = area::find($data->place_id);
                                 if($data->place){
                                     $data->place = $data->place->name_ar;
                                 }else{
                                     $data->place = 'لا يوجد منطقه';
                                 }
                                 
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                     $data->cat = $data->cat->name_ar;
                                 }else{
                                     $data->cat = 'لا يوجد قسم';
                                 }
                  } else {
                         $data->place = area::find($data->place_id);
                                 if($data->place){
                                     $data->place = $data->place->name_en;
                                 }else{
                                     $data->place = 'Not Found Area';
                                 }
                                 
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                     $data->cat = $data->cat->name_en;
                                 }else{
                                     $data->cat = 'Not Found Category';
                                 }
                    }
                    $checkuser  = appUsers::find($data->user_id);
                    if($checkuser){
                       $data->user = appUsers::where('id',$data->user_id)->first()->name;
                    }
                    
                     $checkowner  = appUsers::find($data->owner_id);
                    if($checkowner){
                       $data->owner = appUsers::where('id',$data->owner_id)->first()->name;
                    }
                    
                    unset ($data->images);
                     unset ($data->user_id);
                     unset( $data->place_id);
                    unset( $data->cat_id);
                    $data->imgs = $imageData;
                    $auctions[] =   $data;
                    
            }
            // $auctions = $auctions->paginate(5);
            //  return $this->returnData('Auctions', $auctions);
            //   $auctions = $this->paginate($auctions);
              return view('dashboard.auctions.index', compact('auctions'));
            
            
    }
    //   public function paginate($items, $perPage = 5, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $items instanceof Collection ? $items : Collection::make($items);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function freeAuctions()
    {
         abort_if(!auth()->user()->hasPermission('freeAuctions'), 403);
         $notificationText=appSettings::select('id','free_auctions')->get();;
        return view('dashboard.auctions.free_auctions',compact('notificationText'));
    }
    public function freeAuctions_edit($id){
         abort_if(!auth()->user()->hasPermission('freeAuctions'), 403);
        $about=DB::table('app_settings')->select('free_auctions')->where('id',$id)->first();
        return view('dashboard.auctions.free_auctions_edit',compact('id','about'));
    }
    
      public function freeAuctions_update(Request $request,$id)
    {
         abort_if(!auth()->user()->hasPermission('freeAuctions'), 403);
       $request->validate([
           'free_auctions'=>'required'
       ]);

        $data=$request->except('_token');
        $appSettingss=DB::table('app_settings')->select('free_auctions')->where('id',$id)->update(['free_auctions'=>$request->free_auctions]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.free-Auctions');
    }
    
    public function create()
    {
        //
    }
    
    
    
     public function change_status($id , $status)
    {
         abort_if(!auth()->user()->hasPermission('active_auctions'), 403);
         
         
        $auctiona=Auctions::find($id);
        
        if($status == 1){
            if($auctiona->end_date == NULL){
                $end_date = Carbon::now()->addDays($auctiona->day);
                $endtimeAndDate = $end_date->addHours($auctiona->hours);
                $nowDate = Carbon::now();   
                
                $setting  = appSettings::first(['auction_duration','auction_duration_profile']);
                $end_date_app = Carbon::parse($endtimeAndDate)->addDays($setting->auction_duration);
                $end_date_profile = Carbon::parse($end_date_app)->addDays($setting->auction_duration_profile);
                
                $auctiona->update([
                    'end_date'              => $endtimeAndDate,
                    'end_date_in_app'       => $end_date_app,
                    'end_date_in_profile'   => $end_date_profile,
                ]);
                
                
                
                       $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$auctiona->user_id)->value('token'); 
                                      
                
                        $msg_en = "Your ad has been accepted";
                        $msg_ar = "تم قبول نشر المزاد الخاص بكم" ;
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
                                    'user_id'=> $auctiona->user_id,
                                    'product_id'=> $id,
                                    'type' => 1
                             ]);
                             
                
            }
                
                $auctiona->update([
                    'status'=> 1,
                ]);
            
            
        }elseif($status == 11){
            $auctiona->update([
                            'status'=> 11,
                    ]);
        }elseif($status == 15){
            $auctiona->delete();
            $images =  AuctionImages::where('auction_id' ,  $id)->get();
            
            foreach($images as $img){
                  unlink('laytwfk/public/uploads/auctions/'.$img->img);
            }
          
             AuctionImages::where('auction_id' ,  $id)->delete();
        }
   
      
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.Auctions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    
      public function afterstring()
    {
          abort_if(!auth()->user()->hasPermission('String-after-auction'), 403);
          
        $notificationText=appSettings::select('id','after_acution_ar','after_acution_en')->get();;
        return view('dashboard.acutionstring.index',compact('notificationText'));
    }
       public function afterstringedit($appSettings)
    {
        $about=appSettings::select('id','after_acution_ar','after_acution_en')->first();
        // return response()->json($about);
        return view('dashboard.acutionstring.edit',compact('appSettings','about'));
    }
    
    
    
    public function afterstringupdate(Request $request,$appSettings)
    {
        abort_if(!auth()->user()->hasPermission('String-after-auction'), 403);
        
       $request->validate([
           'after_acution_ar'=>'required',
           'after_acution_en'=>'required',

       ]);

        $data=$request->except('_token');

        $aa=DB::table('app_settings')->where('id',$appSettings)->update(['after_acution_ar'=>$request->after_acution_ar,'after_acution_en'=>$request->after_acution_en]);
        if ($aa){

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.afauctionstring');
        }
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     public function auction_winner(){
         abort_if(!auth()->user()->hasPermission('auction-winners'), 403);
         
         $all_data = Auctions::where('owner_id' , '!=', 0)->orderBy('created_at','DESC')->get();
         
                   $auctions = [];
            foreach( $all_data as $data){
               
             
                    $checkuser  = appUsers::find($data->owner_id);
                    if($checkuser){
                        $data->user = appUsers::where('id',$data->owner_id)->first()->name;
                        $data->phone = appUsers::where('id',$data->owner_id)->first()->phone;
                        $data->email = appUsers::where('id',$data->owner_id)->first()->email;
                    }
                    unset ($data->images);
                    unset ($data->user_id);
                    unset( $data->place_id);
                    unset( $data->cat_id);
                    unset( $data->description);
                    unset( $data->amount_open);
                    unset( $data->maximum_amount);
                    // $data->imgs = $imageData;
                    $auctions[] =   $data;
                    
            }
            // return $auctions;
              return view('dashboard.auctions.winner', compact('auctions'));
              
         
    }
    
    public function auction_winner_details($id){
        
        abort_if(!auth()->user()->hasPermission('auction-winners'), 403);
        
                 $data = Auctions::find($id);
         
                   $auctions = [];

            //  --------------------Winner ------------------------------------------------------------------------
                    $winner_checkuser  = appUsers::find($data->owner_id);
                    if($winner_checkuser){
                        $data->winner_name = appUsers::where('id',$data->owner_id)->first()->name;
                        $data->winner_phone = appUsers::where('id',$data->owner_id)->first()->phone;
                        $data->winner_email = appUsers::where('id',$data->owner_id)->first()->email;
                    }
                    
            // ---------------------------------------Owner--------------------------------------------------------------------   
                    $owner_checkuser  = appUsers::find($data->user_id);
                    if($owner_checkuser){
                        $data->owner_name = appUsers::where('id',$data->user_id)->first()->name;
                        $data->owner_phone = appUsers::where('id',$data->user_id)->first()->phone;
                        $data->owner_email = appUsers::where('id',$data->user_id)->first()->email;
                    }
            // ----------------------------Images ---------------------------------------------------------------------------------
            
            
                    $imageData = [];
                      foreach( $data->images as $image){
                          $imageData[] = asset('uploads/auctions/'.$image->img);
                        //   break;  // get only one image
                          
                }
                
           // -----------------------------Category----------------------------------------------------------------------
                 if (app()->getLocale() == 'ar') {
                              $data->place = area::find($data->place_id);
                                 if($data->place){
                                     $data->place = $data->place->name_ar;
                                 }else{
                                     $data->place = 'لا يوجد منطقه';
                                 }
                                 
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                     $data->cat = $data->cat->name_ar;
                                 }else{
                                     $data->cat = 'لا يوجد قسم';
                                 }
                  } else {
                         $data->place = area::find($data->place_id);
                                 if($data->place){
                                     $data->place = $data->place->name_en;
                                 }else{
                                     $data->place = 'Not Found Area';
                                 }
                                 
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                     $data->cat = $data->cat->name_en;
                                 }else{
                                     $data->cat = 'Not Found Category';
                                 }
                    }
                    
        //  ----------------------------------Money-------------------------------------------
                  $ckeckprice = auction_users::where("auction_id" , $id)->where("user_id" , $data->owner_id)->orderBy('id', 'desc')->first();
                  if($ckeckprice){
                      $data->money = $ckeckprice->price;
                  }
        
                    unset ($data->images);
                    unset ($data->user_id);
                    unset( $data->place_id);
                    unset( $data->cat_id);
                    $data->imgs = $imageData;
                    $auctions[] =   $data;
                    
            
            // return $data;
              return view('dashboard.auctions.winner-details', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         abort_if(!auth()->user()->hasPermission('update_auctions'), 403);
         
             $data = Auctions::find($id);
             if($data){
             if($data->status != 0){
                 return redirect()->route('dashboard.Auctions');    
             }
                    $imageData = [];
                      foreach($data->images as $image){
                          $imageData[]['img'] = asset('uploads/auctions/'.$image->img);
                          $imageData[]['id'] = $image->id;
                        //   break;  // get only one image
                          
                }
                 if (app()->getLocale() == 'ar') {
                              $data->place = area::find($data->place_id);
                                 if($data->place){
                                     $data->place = $data->place->name_ar;
                                 }else{
                                     $data->place = 'لا يوجد منطقه';
                                 }
                                 
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                     $categores = Catgories::where('parent_id',$data->cat->parent_id)->get();
                                     $data->cat = $data->cat->name_ar;
                                 }else{
                                      $categores = Catgories::where("parent_id" , 2)->get();
                                     $data->cat = 'لا يوجد قسم';
                                 }
                  } else {
                         $data->place = area::find($data->place_id);
                                 if($data->place){
                                     $data->place = $data->place->name_en;
                                 }else{
                                     $data->place = 'Not Found Area';
                                 }
                                 
                                 $data->cat = Catgories::find($data->cat_id);
                                 if($data->cat){
                                     $categores = Catgories::where('parent_id',$data->cat->parent_id)->get();
                                     $data->cat = $data->cat->name_en;
                                 }else{
                                     $categores = Catgories::where("parent_id" , 2)->get();
                                     $data->cat = 'Not Found Category';
                                 }
                    }
                    $checkuser  = appUsers::find($data->user_id);
                    if($checkuser){
                       $data->user = appUsers::where('id',$data->user_id)->first()->name;
                    }
                    $data->imgs = $imageData;
                    $auctions =   $data;
                    $areas = area::get();
                    // return $auctions;
                 return view('dashboard.auctions.edit', compact('auctions' , "categores","areas"));
             }
             
              return redirect()->route('dashboard.Auctions');     
    }

    public function show_auction($id){
            abort_if(!auth()->user()->hasPermission('read_advertiments'), 403);
  
                 $auctions = Auctions::find($id);
                 $images = AuctionImages::where("auction_id" ,$id)->get();
                 $filters = category_item_products::where('product_id',$id)->where('type',1)->get();
            
            
              $categores = Catgories::find($auctions->cat_id);
              $areas = area::find($auctions->place_id);
            
              return view('dashboard.auctions.auction-details',compact('auctions','images','filters','categores','areas'));
        }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     public function auction_duration(){
         abort_if(!auth()->user()->hasPermission('auctions_duration'), 403);
         
        $data=appSettings::first(['auction_duration','auction_duration_profile']);
        return view('dashboard.auctions.auctions_duration',compact('data'));
        
    }
            
     public function auction_duration_update(Request $request){
         abort_if(!auth()->user()->hasPermission('auctions_duration'), 403);
         
            appSettings::first()->update([
                                    'auction_duration'          =>$request->auction_duration,
                                    'auction_duration_profile'  =>$request->auction_duration_profile,
                                    ]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back();
    }


     
        public function auctions_introduction_video(){
        abort_if(!auth()->user()->hasPermission('auctions_introduction_video'), 403);
        
        $appSettings = appSettings::first(['auctions_introduction_video']);
        return view('dashboard.auctions.introduction_video', compact('appSettings'));
    }
    
     public function update_auctions_introduction_video(Request $request){ 
          abort_if(!auth()->user()->hasPermission('auctions_introduction_video'), 403);
          
                $app = appSettings::find(1);
               $app->update([
                            'auctions_introduction_video'=>$request->video
                    ]);
            

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.auctions_introduction_video');
        
    }
    
    
    
    public function maximum_auction_duration(){
         abort_if(!auth()->user()->hasPermission('The-maximum-duration-of-the-auction'), 403);
         
        $data=appSettings::first(['maximum_duration_auction']);
        return view('dashboard.auctions.maximum_duration_auction',compact('data'));
        
    }
            
     public function maximum_auction_duration_update(Request $request){
          abort_if(!auth()->user()->hasPermission('The-maximum-duration-of-the-auction'), 403);
          
            appSettings::first()->update([
                                    'maximum_duration_auction'          => $request->maximum_duration_auction,
                                    ]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back();
    }

    
       public function delete_image(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('update_auctions'), 403);
        $image =  AuctionImages::find($request->id);
        unlink('laytwfk/public/uploads/auctions/'.$image->img);
        $image->delete();  
    }
    public function update(Request $request, $id)
    { 
         abort_if(!auth()->user()->hasPermission('update_auctions'), 403);
         $request->validate([
            'name'=>'required',
            'description'=>'required',
            'amount_open'=>'required',
            'maximum_amount'=>'required',
            'day'=>'required',
            'hours'=>'required',
            'place_id'=>'required',
            'cat_id'=>'required',
            'deposit_amount'=>'required',
        ]);


         $auctions = Auctions::find($id);
           $auctions->update([
                'name' => $request->name,
                'description' => $request->description,
                'amount_open' => $request->amount_open,
                'maximum_amount' => $request->maximum_amount,
                'day' => $request->day,
                'hours' => $request->hours,
                'place_id' => $request->place_id,
                'cat_id' => $request->cat_id,
                'deposit_amount'=>$request->deposit_amount

            ]);
            if(!empty($request->file('images'))){
                    foreach($request->file('images') as $img){
                           $imageName = $this->storeImages($img, 'laytwfk/public/uploads/auctions/');
                           AuctionImages::create([
                            'img' => $imageName,
                            'auction_id' => $auctions->id,
                            
                        ]);

                     }
            }
           
             return redirect()->route('dashboard.Auctions');     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
