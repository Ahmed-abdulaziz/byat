<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auctions;
use App\AuctionImages;
use App\Models\appUsers;
use App\Models\appSettings;
use App\Models\area;
use App\Models\Catgories;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use Carbon\Carbon;
use App\auction_users;
use App\depoist_payment_users;
use App\Http\Resources\UserWalletResource;
use App\Http\Resources\AuctionResources;
use App\Http\Resources\singleAuctionResources;
use App\users_wallet;
use App\Traits\notifcationTrait;
use Illuminate\Support\Facades\DB;
use App\Notifications;
use App\category_item_products;
use App\bills;
use App\Monthly_withdrawals;
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
 
     function __construct() {
         
        $this->currentdate = Carbon::today()->toDateString();
      }
      
          
    public function index()
    {
        //
    }
    
    
     public function depoist_payment(Request $request){
             $rules = [
                      'user_id' => 'required|integer',
                      'auction_id' => 'required|integer',
                      'amount' => 'required|numeric',
                      'paymentmethod' => 'required|numeric',
         ];
         
          $valdator = Validator::make($request->all(), $rules);
             if ($valdator->fails()) {
                $code = $this->returnCodeAccordingToInput($valdator);
                return $this->returnValidationError($code, $valdator);
            } else {
                
                $auction = Auctions::find($request->auction_id);
                if($auction){
                            $checkdepoist = depoist_payment_users::where('user_id',$request->user_id)->where('auction_id',$request->auction_id)->get();
                            if($checkdepoist->count() < 1){
                                        if($request->amount == $auction->deposit_amount){
                                                
                                                $user = appUsers::find($request->user_id);
                                                if($user){ 
                                                            if($request->paymentmethod == 2){   // wallet
                                                                 $amount=users_wallet::where('user_id',$request->user_id)->sum('money');
                                                                 if($amount >=$request->amount){
                                                                     
                                                                      depoist_payment_users::create([
                                                                            'user_id'=> $request->user_id,
                                                                            'auction_id'=> $request->auction_id,
                                                                            'amount'=> $request->amount,
                                                                     ]);
                                                                     
                                                                     users_wallet::create([
                                                                            'user_id'=> $request->user_id,
                                                                            'money'=> $request->amount * -1 ,
                                                                             'auction_id'=> $request->auction_id,
                                                                            'comment'=> 'دفع تامين مزاد',
                                                                     ]);
                                                                     
                                                                      bills::create([
                                                                            'user_id'=> $request->user_id,
                                                                            'price'=> $request->amount  ,
                                                                            'product'=> $auction->name  ,
                                                                            'product_id'=> $auction->id  ,
                                                                            'name_ar'=> 'تامين مزاد',
                                                                            'name_en'=> 'Auction insurance',
                                                                            'payment_method'=> 'wallet',
                                                                        ]);
                                                                        
                                                                
                                                                 }else{
                                                                        if (app()->getLocale() == 'ar') {
                                                                            return $this->returnData('status',false, 'لا يوجد لديك رصيد كافى فى المحفظه');
                                                                     } else {
                                                                         return $this->returnData('status',false, 'You dont have enough wallet balance');
                                                                        }
                                                                 }
                                                             
                                                            }elseif($request->paymentmethod == 3){    // api charge  
                                                                
                                                                if(isset($request->trans_id)){
                                                                    depoist_payment_users::create([
                                                                            'user_id'=> $request->user_id,
                                                                            'auction_id'=> $request->auction_id,
                                                                            'amount'=> $request->amount,
                                                                            'trans_id'=> $request->trans_id
                                                                     ]);
                                                                     
                                                                      bills::create([
                                                                            'user_id'=> $request->user_id,
                                                                            'price'=> $request->amount  ,
                                                                            'product'=> $auction->name  ,
                                                                            'name_ar'=> 'تامين مزاد',
                                                                            'name_en'=> 'Auction insurance',
                                                                            'payment_method'=> 'Online payment',
                                                                        ]);
                                                                }else{
                                                                     return $this->returnData('status',false, 'trans_id is required');
                                                                }
                                                                    
                                                                     
                                                            }
                                                             
                                                                             
                                                          $check =   Monthly_withdrawals::where('month', 'like', '%' . Carbon::now()->format('Y-m') . '%' )->count();
                                                          
                                                          if($check > 0){
                                                                if (app()->getLocale() == 'ar') {
                                                                        $msg = 'تهانينا لك دخلت السحب الشهرى';
                                                                }else{
                                                                        $msg = 'Congratulations, you entered the monthly draw';
                                                                }
                                                                
                                                                 return $this->returnData('type',1, $msg);
                                                          }
                                      
                                                          if (app()->getLocale() == 'ar') {
                                                                 return $this->returnData('type',2, 'تم دفع تامين المزاد بنجاح');
                                                            } else {
                                                            return $this->returnData('type',2, 'Auction deposit paid successfully');
                                                            }
                                                            
                                                }else{
                                                    
                                                       if (app()->getLocale() == 'ar') {
                                                                 return $this->returnData('status',false, 'لا يوجد هذا المستخدم');
                                                         
                                                         } else {
                                                            return $this->returnData('status',false, 'This user does not exist');
                                                            }
                                                         
                                                }
                                                
                                            
                                        }else{
                                            
                                             if (app()->getLocale() == 'ar') {
                                                        return $this->returnData('status',false,  "قيمة التامين غير صحيحه . برجاء دفع : $auction->deposit_amount ");
                                 
                                             } else {
                                                    return $this->returnData('status',false, "Invalid insurance amount. Please pay: $auction->deposit_amount");                                             }
                                            
                                        }
                                
                            }else{
                                if (app()->getLocale() == 'ar') {
                                         return $this->returnData('status',false, 'تم دفع تامين هذا المزاد من قبل');
                                 
                                 } else {
                                        return $this->returnData('status',false, 'This auction deposit has already been paid ');
                                 }
                            }

                }else{
                      return $this->returnData('status',false, 'Not Found This Auction');
                }
                
                
            }
     }
    
     public function show_user_auctions($id){
        
         $all_data = Auctions::where('user_id',$id)->where('end_date_in_profile','>=',$this->currentdate)->where('status','!=',11)->orderBy('id','DESC')->get();
            if(count($all_data) > 0){
                $resource=singleAuctionResources::collection($all_data);
                return $this->returnData('auctions', $resource); 
            }else{
                 return $this->returnData('status',false, 'Not Found Data');
            }
        
    }
    
     public function images($id){
        $all_data = Auctions::find($id)->images;
        return $this->returnData('auctions', $all_data);
        print_r($all_data);
    }
    
       public function check_user_count_auctions($id){
            
            $freeauction = appUsers::find($id);
            return $this->returnData('count',$freeauction->auctions_number);
    }
    
       public function get_all_user_auctions($id){
         

          $all_data =  auction_users::where('auction_id',$id)->get();
              if(count($all_data) > 0){
                      foreach( $all_data as $data){
                           
                              $user = appUsers::where('id',$data->user_id)->first();
                              $data->img = asset('uploads/user_images/'.$user->img);
                              $data->user_name = appUsers::where('id',$data->user_id)->first()->name;
                     
                            
                            unset ($data->user_id);
                            unset( $data->auction_id);
                         
                            $values[] =   $data;
                            
                    }
                    return $this->returnData('auctions', $values);
            }else{
                 return $this->returnData('status',false, 'Not Found Data');
            }

        
    }
    
    
     public function user_auction(Request $request){
             $rules = [
                      'user_id' => 'required|integer',
                      'auction_id' => 'required|integer',
                      'price' => 'required|numeric',
         ];
          $valdator = Validator::make($request->all(), $rules);
             if ($valdator->fails()) {
                $code = $this->returnCodeAccordingToInput($valdator);
                return $this->returnValidationError($code, $valdator);
            } else {
                
                
         $main_auctions = Auctions::find($request->auction_id);
          $main_appUsers = appUsers::find($request->user_id);
                if(!$main_auctions){
                    if (app()->getLocale() == 'ar') {
                                   $msg = "لا يوجد هذا المزاد";
                          } else {
                                  $msg = "Auction Not Found";
                            }
                   
                    return $this->returnData('status',false, $msg);
                }
                
                 if(!$main_auctions->status == 11){
                    if (app()->getLocale() == 'ar') {
                                   $msg = "تم حظر هذا المزاد";
                          } else {
                                  $msg = "Auction Is Blocked ";
                            }
                   
                    return $this->returnData('status',false, $msg);
                }
                
                
                      // ------------------------Check if owner has this auction --------------------------------------------------
                                if($main_auctions->user_id == $request->user_id){
                                     if (app()->getLocale() == 'ar') {
                                                   $msg = "مالك المزاد لا يمكن ان يزايد";
                                          } else {
                                                  $msg = "Auction owner cannot bid";
                                            }
                                   
                                    return $this->returnData('status',false, $msg);
                                }
                
            // --------------------------------------------------------------------------------------------------------------------------
            
            
                $checkdepoist = depoist_payment_users::where('user_id',$request->user_id)->where('auction_id',$request->auction_id)->count();
                if($checkdepoist < 1){
                       if (app()->getLocale() == 'ar') {
                                   $msg = "برجاء دفع تامين المزاد اولا";
                          } else {
                                $msg = "Please pay the auction deposit first";    
                                }
                   
                    return $this->returnData('status',false, $msg);
                }
            
            
                // ---------------------------------------Check status of auction-----------------------------------------------------
                    
                    if($main_auctions->status == 2){
                        
                         if (app()->getLocale() == 'ar') {
                                   $msg = "تم أنتهاء هذا المزاد";
                          } else {
                                  $msg = "Auction  has expired";
                            }
                             return $this->returnData('status',false, $msg );
                   
                   
                    }
                    
                       if($main_auctions->status == 3){
                        
                         if (app()->getLocale() == 'ar') {
                                   $msg = "تم أنتهاء وقت هذا المزاد ";
                          } else {
                                  $msg = "Auction Time  has expired";
                            }
                             return $this->returnData('status',false, $msg );
                   
                   
                    }
                
                // ----------------------------------------------------------------------------------------------------------------------
                // -------------------------------------------------------------------------------------------
                // ------------------------Check date --------------------------------------------------
           //   ------------------------------Check Expired Auctions-----------------------------------------------
                                            $nowDate = Carbon::now();
                                            $check_date_of_auction = $nowDate->gt($main_auctions->end_date);
                                            
                                             if($check_date_of_auction && $main_auctions->status == 1){
                                                 
                                                    $check_count = auction_users::where('auction_id',$data->id)->count();
                                                    
                                                    if($check_count > 0){
                                                        $last_user = auction_users::latest()->first();
                                                           $allpayment = depoist_payment_users::where('auction_id',$data->id)->where('user_id','!=',$last_user->user_id)->get();
                                                            foreach($allpayment as $payment){
                                                                   $resource=$this->back_users_deposit($payment);
                                                                   $payment->update([
                                                                        'status'=> 1,
                                                                    ]);
                                                            }
                                                             $main_auctions->update([
                                                                'status'=> 2,
                                                                'owner_id'=>$last_user->user_id,
                                                            ]);
                                                
                                                              $data->status = 2;
                                                           if (app()->getLocale() == 'ar') {
                                                                           $msg = "تم أنتهاء هذا المزاد";
                                                                  } else {
                                                                          $msg = "Auction  has expired";
                                                                    }
                                                                     return $this->returnData('status',false, $msg );
                                                    }else{
                                                 
                                                     $main_auctions->update([
                                                        'status'=> 3,
                                                    ]);
                                                
                                                             
                                                         if (app()->getLocale() == 'ar') {
                                                                   $msg = "تم أنتهاء وقت هذا المزاد ";
                                                          } else {
                                                                  $msg = "Auction Time  has expired";
                                                            }
                                                             return $this->returnData('status',false, $msg );
                                                    }
                                             }
                             
                                    //------------------------------------------------------------------------------------------------- 
       
            
            // ------------------------------------------------------------------------------------------------------------------------------
            // if($main_auctions->maximum_amount <= $request->price){
                
            //      $allpayment = depoist_payment_users::where('auction_id',$request->auction_id)->where('user_id','!=',$request->user_id)->get();
            //      foreach($allpayment as $payment){
            //             $resource=$this->back_users_deposit($payment);
                        
            //             $payment->update([
            //                 'status'=> 1,
            //             ]);
                        
            //      }
                    
            //     $auctions = auction_users::create([
            //             'user_id'=> $request->user_id,
            //             'auction_id' => $request->auction_id,
            //             'price' => $request->price,

            //      ]);
            //      $main_auctions->update([
            //             'status'=> 2,
            //              'owner_id'=>$request->user_id,
            //         ]);
                    
                    
            //                   // ----------------------------------------Send Notifications---------------------------------------------------------------------------
            // $allusers = depoist_payment_users::where('auction_id',$request->auction_id)->where('user_id','!=',$request->user_id)->get();
            // foreach($allusers as $user){
                
            //       $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$user->user_id)->value('token');
            //          $msg = "عفوا لقد اغلق المزاد الذى زايدت عليه";
            //             if(!empty($fcmtoken)){
                            
                           
            //                     $this->pushNotification([  
            //                         'order_id' => null,
            //                         'title'=> 'laytwfk' ,
            //                         'body'=> "$msg",
            //                         'click_action'=> "ACTION_NORMAL" ,
            //                         'device_token' => [$fcmtoken],
            //                         'id'=> null
            //                     ]);
                        
                
            //             }
                        
            //               Notifications::create([
            //                     'msg'=> $msg,
            //                     'title'=> 'laytwfk',
            //                     'user_id'=> $user->user_id,
            //                     'product_id'=> $request->auction_id,
            //                     'type' => 1
            //              ]);
                      
            // }
            
            // // -----------------------
            //   $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$request->user_id)->value('token');
            //           $msg =  " مبروك. لقد رسى عليك المزاد";
            //             if(!empty($fcmtoken)){
            //                 $winner = appUsers::find($request->user_id);
            //                     $this->pushNotification([  
            //                         'order_id' => null,
            //                         'title'=> 'laytwfk' ,
            //                         'body'=> "$msg",
            //                         'click_action'=> "ACTION_NORMAL" ,
            //                         'device_token' => [$fcmtoken],
            //                         'id'=> null
            //                     ]);
                        
                
            //             }
                        
            //           Notifications::create([
            //                 'msg'=> $msg,
            //                 'title'=> 'laytwfk',
            //                 'user_id'=> $request->user_id,
            //                 'product_id'=> $request->auction_id,
            //                 'type' => 1
            //          ]);
            // // ----------------------------------
            
            
            //   $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$main_auctions->user_id)->value('token');
                          
            //         $msg = " لقد رسى المزاد الخاص بك على 
            //         ".$winner->name;
            //             if(!empty($fcmtoken)){
                
            //                     $this->pushNotification([  
            //                         'order_id' => null,
            //                         'title'=> 'laytwfk' ,
            //                         'body'=> "$msg",
            //                         'click_action'=> "ACTION_NORMAL" ,
            //                         'device_token' => [$fcmtoken],
            //                         'id'=> null
            //                     ]);
                        
                
            //             }
                        
            //           Notifications::create([
            //                 'msg'=> $msg,
            //                 'title'=> 'laytwfk',
            //                 'user_id'=> $main_auctions->user_id,
            //                 'product_id'=> $request->auction_id,
            //                 'type' => 1
            //          ]);
                
                
                
            
            // // --------------------------------------------------------------------------------------------------------------------------------------------------------
            
                
            //             if (app()->getLocale() == 'ar') {
            //                         $msg = "تمت المزايده بقيمه اعلى من الحد الاقصى . تمت المزايده بنجاح";
            //               } else {
            //                           $msg = "The bid has been completed with a value higher than the maximum. Bidding has been successful.";
            //                   }
            //                 return $this->returnData('status',true, $msg);
            // }
            // ------------------------------------------------------------------------------------------------------------------------------
            
            $auction_users = auction_users::where('auction_id',$request->auction_id)->count();
            if($auction_users < 1){
                $min_amount = $main_auctions->amount_open;
            }else{
                $min = auction_users::where('auction_id',$request->auction_id)->get()->last();
                $min_amount =$min->price;
            }
            
            if($min_amount >= $request->price ){
                
                  if (app()->getLocale() == 'ar') {
                                   $msg = " لا يمكن المزايده بهذا السعر .الحد الادنى للمزايده حاليا :  دينار  $min_amount";
                          } else {
                                  $msg = "This price can be bid. Minimum bid price :  $min_amount KWD";
                            }
                   
                    return $this->returnData('status',false, $msg);
                    
            }
            
             $auctions = auction_users::create([
                'user_id'=> $request->user_id,
                'auction_id' => $request->auction_id,
                'price' => $request->price,

            ]);
            
            // ----------------------------------------Send Notifications---------------------------------------------------------------------------
            $allusers = depoist_payment_users::where('auction_id',$request->auction_id)->where('user_id','!=',$request->user_id)->get();
            foreach($allusers as $user){
                
                  $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$user->user_id)->value('token');
                   $msg = "تمت المزايده من قبل  $main_appUsers->name على المزاد $main_auctions->name " ;
                        if(!empty($fcmtoken)){
                            
                                $this->pushNotification([  
                                    'order_id' => null,
                                    'title'=> 'laytwfk' ,
                                    'body'=> "$msg",
                                    'click_action'=> "ACTION_NORMAL" ,
                                    'device_token' => [$fcmtoken],
                                    'id'=> $request->auction_id,
                                    'type'=>'auction'
                                ]);
                        
                
                        }
                        
                          Notifications::create([
                                'msg'=> $msg,
                                'title'=> 'laytwfk',
                                'user_id'=> $user->user_id,
                                'product_id'=> $request->auction_id,
                                'type' => 1
                         ]);
                      
            }
            
            
            // -----------------------------------
            
            
                  
                         $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$main_auctions->user_id)->value('token');
                        $msg = "تمت المزايده من قبل  $main_appUsers->name على المزاد $main_auctions->name " ;
                        if(!empty($fcmtoken)){
                                $this->pushNotification([  
                                    'order_id' => null,
                                    'title'=> 'laytwfk' ,
                                    'body'=> "$msg",
                                    'click_action'=> "ACTION_NORMAL" ,
                                    'device_token' => [$fcmtoken],
                                    'id'=> $request->auction_id,
                                    'type'=>'auction'
                                ]);
                        
                              Notifications::create([
                                        'msg'=> $msg,
                                        'title'=> 'laytwfk',
                                        'user_id'=> $main_auctions->user_id,
                                        'product_id'=> $request->auction_id,
                                        'type' => 1
                            ]);
                        }
                        
                    
                
                
                
            
            // --------------------------------------------------------------------------------------------------------------------------------------------------------
            
            
            // --------------------------------------------------------------------------------------------------------------------------------------------------------
          
                
        
            
              if (app()->getLocale() == 'ar') {
                                    $msg = "تمت المزايده بنجاح";
                          } else {
                                    $msg = "Bid completed successfully";     
                            }
                   
                    return $this->returnData('msg', $msg);
            
                
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
              if(isset($request->getall)){
                        $cates = Catgories::where('parent_id',$request->cat_id)->get(['id']);
                        $child_cat = [];
                        foreach($cates as $cate){
                            $child_cat[] = $cate->id;
                        }
                $all_data = Auctions::where('place_id',$request->place_id)->where('end_date_in_app','>=',$this->currentdate)->whereIn('cat_id',$child_cat)->where('status','!=',0)->where('status',"!=", 11)->get();
                
                // return $child_cat;
               $all_data = Auctions::where('place_id',$request->place_id)->where('end_date_in_app','>=',$this->currentdate)->whereIn('cat_id',$child_cat)->where('status','!=',0)->where('status',"!=", 11)->orderBy('created_at', 'DESC')->orderBy('end_date', 'DESC')->get();
                        
                
            }else{
             $all_data = Auctions::where('place_id',$request->place_id)->where('end_date_in_app','>=',$this->currentdate)->where('cat_id',$request->cat_id)->where('status','!=',0)->where('status',"!=", 11)->orderBy('created_at', 'DESC')->orderBy('end_date', 'DESC')->get();
            }
            // print_r($all_data);die;
            if(count($all_data) > 0){
                $resource=singleAuctionResources::collection($all_data);
                return $this->returnData('auctions', $resource); 
            }else{
                 return $this->returnData('status',false, 'Not Found Data');
            }
            
        }
          
            
     
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function check_payment_wallet(Request $request){
                
                
                $rules = [
                    'user_id' => 'required|integer',
                    'auction_id' => 'required|integer',
                ];
                $valdator = Validator::make($request->all(), $rules);
                 if ($valdator->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdator);
                    return $this->returnValidationError($code, $valdator);
                } else {
                    
                     $checkdepoist = depoist_payment_users::where('user_id',$request->user_id)->where('auction_id',$request->auction_id)->count();
                        if($checkdepoist < 1){
                                 return $this->returnData('status',false );
                          }else{
                                   return $this->returnData('status',true );
                             }
                }
                    
               
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $rules = [
            'user_id'                   => 'required|integer',
            'imgs'                      => 'required|array',
            'name'                      => 'required|string',
            'description'               => 'required|string|min:10',
            'amount_open'               => 'required',
            'maximum_amount'            => 'required',
            'day'                       => 'required|integer',
            // 'hours'                     => 'required|integer',
            'place_id'                  => 'required|integer|exists:areas,id',	
            'cat_id'                    => 'required|integer|exists:catgories,id',
            'filter_id'                 => 'required|array',
        ];
        $valdator = Validator::make($request->all(), $rules);
         if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            
        
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
              if($request->day > $appSettings->maximum_duration_auction){
                   return $this->returnError('',"maximum duration of auction ".$appSettings->maximum_duration_auction);
              }
           
          
             $User = appUsers::find($request->user_id);
            if($User->auctions_number < 1 ){
                return $this->returnData('msg', 'User has passed the number of Auctions');
            }else{
                
           if ($request->maximum_amount < $request->amount_open){
               
                         if (app()->getLocale() == 'ar') {
                             $msg = "يجب ان يكون الحد الادنى للمزايده اقل من الحد الاقصى";
                          } else {
                                $msg = "The minimum bid must be less than the maximum";
                            }
                        return $this->returnData('msg', $msg);     
           }
            
             if(isset($request->examination_certificate)){
                        $examination= $this->storeImages($request->examination_certificate, $this->main_path().'uploads/auctionsexamination_certificate/');
             }else{
                        $examination = NULL;
             }
             
          
            $auctions = Auctions::create([
                'user_id'                           => $request->user_id,
                'name'                              => $request->name,
                'description'                       => $request->description,
                'amount_open'                       => $request->amount_open,
                'maximum_amount'                    => $request->maximum_amount,
                'day'                               => $request->day,
                'hours'                             => $request->hours ? $request->hours : 0,
                'place_id'                          => $request->place_id,
                'cat_id'                            => $request->cat_id,
                'deposit_amount'                    => $appSettings->deposit_amount,
                'examination_certificate'           => $examination,

            ]);//create user
            
              
                for($i=0;$i<count($request->filter_id);$i++){
                        $text = NULL;
                        $sub_filter_id = NULL;
                        if(!empty( $request->text)){
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
                            'product_id'                        => $auctions->id,
                            'type'                              => 1,
                        ]);
                }
                
                
                
               foreach($request->imgs as $img){
                           $imageName = $this->storeImages($img, $this->main_path().'uploads/auctions/');
                           AuctionImages::create([
                            'img' => $imageName,
                            'auction_id' => $auctions->id,
                            
                        ]);
                        $images[] =asset('uploads/auctions/'.$imageName);
                      
                     }
                     
                    
                    $User->update(['auctions_number'=>$User->auctions_number-- ]); 
                    
                    if(app()->getLocale() == 'ar'){
                        $msg = $appSettings->after_acution_ar;
                    }else{
                        $msg = $appSettings->after_acution_en;
                    }
                    
                    $data = Auctions::find($auctions->id);
                    $resource=new AuctionResources($data);
                    
                    return $this->returnData('auctions', $resource , $msg);
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        
            $data = Auctions::find($request->id);
            
             if($data){
                        $resource=new AuctionResources($data);
                        return $this->returnData('auctions', $resource);       
              }else{
                         return $this->returnData('status',false, 'Not Found Data');
                }
        
    }
    
        public function showall(){
            $all_data = Auctions::orderBy('created_at', 'DESC')->where('end_date_in_app','>=',$this->currentdate)->orderBy('end_date', 'DESC')->get();
             if($all_data->count() > 0){
                     $resource=singleAuctionResources::collection($all_data);
                     return $this->returnData('auctions', $resource);  
             }else{
                 return $this->returnData('status',false, 'Not Found Data');
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
            
                if(isset($request->search)){
                     $all_data = Auctions::where('cat_id',$request->id)->where('end_date_in_app','>=',$this->currentdate)->Where('name', 'like', '%' . $request->search . '%')->where('status','!=',0)->where('status','!=',11)->orderBy('created_at', 'DESC')->orderBy('end_date', 'DESC')->get();
                }else{
                     if(isset($request->getall)){
                        $cates = Catgories::where('parent_id',$request->id)->get(['id']);
                        $child_cat = [];
                        foreach($cates as $cate){
                            $child_cat[] = $cate->id;
                        }
                        // return $child_cat;
                                $all_data = Auctions::whereIn('cat_id',$child_cat)->where('end_date_in_app','>=',$this->currentdate)->where('status','!=',0)->where('status','!=',11)->orderBy('created_at', 'DESC')->orderBy('end_date', 'DESC')->get();                
                        }else{
                             $all_data = Auctions::where('cat_id',$request->id)->where('end_date_in_app','>=',$this->currentdate)->where('status','!=',0)->where('status','!=',11)->orderBy('created_at', 'DESC')->orderBy('end_date', 'DESC')->get();
            
                        }
                }
                   if(count($all_data) > 0){
                                $resource=singleAuctionResources::collection($all_data);
                                return $this->returnData('auctions', $resource);  
                   }else{
                 return $this->returnData('status',false, 'Not Found Data');
            }
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     public function textnoti(Request $request){
                            $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$request->id)->value('token'); 
                            if(!empty($fcmtoken)){
                            
                            //   $msg = "Test Notifcation From Ahmed" ;
                                $this->pushNotification([  
                                    'order_id' => null,
                                    'title'=> 'laytwfk' ,
                                    'body'=> $request->msg,
                                    'click_action'=> "ACTION_NORMAL" ,
                                    'device_token' => [$fcmtoken],
                                    'id'=> 0,
                                    'type'=>'auction'
                                ]);
                                
                                
                            Notifications::create([
                                'msg'=> $request->msg,
                                'title'=> 'laytwfk',
                                'user_id'=> $request->id,
                                'product_id'=> 0,
                                'type' => 1
                         ]);
                        
                            return $this->returnData('status',true, 'Success');
                        }
     }
    public function destroy($id)
    {
        //
    }
    
   public function last_auction_user($id)
    {

             
            $data = Auctions::find($id);
            if($data){
                      $winner_user = auction_users::where('auction_id',$data->id)->orderBy('price','DESC')->first();
                        if($winner_user){
                            $winner      =    appUsers::find($winner_user->user_id); 
                            if($winner){
                                $user['name'] = $winner->name;
                                $user['phone'] = $winner->phone;
                                $user['price'] = $winner_user->price;
                                
                                return $this->returnData('data',$user);
                            }
                        }
                                            // Retrieved

                     return $this->returnData('status',true, 'Not found data');
                
              
              
                
            }
              return $this->returnData('status',false, 'Not found data');

    }
    
      public function pay_auction(Request $request){

                $rules = [
                    'auction_id' => 'required|integer',
                ];
                $valdator = Validator::make($request->all(), $rules);
                 if ($valdator->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdator);
                    return $this->returnValidationError($code, $valdator);
                }
                
                
            $data = Auctions::where('id',$request->auction_id)->where('owner_id',0)->first();
            if($data){
                if($request->status == 1){          // paid
                      $winner_user = auction_users::where('auction_id',$data->id)->orderBy('price','DESC')->first();
                        if($winner_user){
                            $winner      =    appUsers::find($winner_user->user_id); 
                            if($winner){
                                // -------------------------------
                                        
                                                $allpayment = depoist_payment_users::where('auction_id',$data->id)->where('user_id','!=',$winner_user->user_id)->get();
                                                            foreach($allpayment as $payment){
                                                                  $resource=$this->back_users_deposit($payment);
                                                                  $payment->update([
                                                                        'status'=> 1,
                                                                    ]);
                                                                    
                                                                    
                                                                      $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$payment->user_id)->value('token');
                                                                         $msg = "عفوا لقد اغلق المزاد الذى زايدت عليه";
                                                                            if(!empty($fcmtoken)){
                                                                               
                                                                                    $this->pushNotification([  
                                                                                        'order_id' => null,
                                                                                        'title'=> 'laytwfk' ,
                                                                                        'body'=> "$msg",
                                                                                        'click_action'=> "ACTION_NORMAL" ,
                                                                                        'device_token' => [$fcmtoken],
                                                                                        'id'=> null,
                                                                                        'type'=> null
                                                                                    ]);
                                                                            }
                                                                            
                                                                              Notifications::create([
                                                                                    'msg'=> $msg,
                                                                                    'title'=> 'laytwfk',
                                                                                    'user_id'=> $payment->user_id,
                                                                                    'product_id'=> $data->id,
                                                                                    'type' => 1
                                                                             ]);
                                                            }
                                                             $data->update([
                                                                'status'=> 2,
                                                                'owner_id'=>$winner_user->user_id,
                                                            ]);
                                                
                                                                        $winner = appUsers::find($winner_user->user_id);
                                                                      $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$winner_user->user_id)->value('token');
                                                                            $msg =  " مبروك. لقد رسى عليك المزاد";
                                                                            if(!empty($fcmtoken)){
                                                                               
                                                                                    $this->pushNotification([  
                                                                                        'order_id' => null,
                                                                                        'title'=> 'laytwfk' ,
                                                                                        'body'=> "$msg",
                                                                                        'click_action'=> "ACTION_NORMAL" ,
                                                                                        'device_token' => [$fcmtoken],
                                                                                        'id'=> null,
                                                                                        'type'=> null
                                                                                    ]);
                                                                            
                                                                    
                                                                            }
                                                                            
                                                                               Notifications::create([
                                                                                    'msg'=> $msg,
                                                                                    'title'=> 'laytwfk',
                                                                                    'user_id'=> $winner_user->user_id,
                                                                                    'product_id'=> $data->id,
                                                                                    'type' => 1
                                                                             ]);
                                                                            
                                
                                // ----------------------------------
                                  if(app()->getLocale() == 'ar'){
                                         $msg = 'تم البيع بنجاح';
                                    }else{
                                           $msg = 'The sale has been completed successfully';
                                    }
                                  
                                     return $this->returnData('msg', $msg);
                                     
                            }
                        }
                        
                          if(app()->getLocale() == 'ar'){
                                  $msg = 'لم يزايد احد على هذا المزاد';
                            }else{
                                   $msg = 'Not Found Users Auction';
                            }
                          
                             return $this->returnData('msg', $msg);
                             
                }else{                              // Retrieved
                    $data->update(['status'=>4]);
                    
                        
                            if(app()->getLocale() == 'ar'){
                                  $msg = ' تم استرجاع المزاد';
                            }else{
                                   $msg = 'The auction has been restored';
                            }
                          
                             return $this->returnData('msg', $msg);
                             
                }
              
            }
                
            
              return $this->returnData('status',false, 'Not found data');

    }
    
      
       public function repost(Request $request , $auction_id){
           
            
               $token = $request->bearerToken();
                $id = $this->getUserID($token);  
                if(!is_numeric($id)){
                    return $id;
                }
        
                
                
                    $appSettings = appSettings::first();
                    $User = appUsers::find($id);

                    
                    $auction = Auctions::find($auction_id);
                    if($auction){
                        if($auction->repost != 0){
                            
                             if(app()->getLocale() == 'ar'){
                                  $msg = 'غير مسموح بإعادة النشر الا مره واحده فقط مجانا';
                            }else{
                                   $msg = 'It is not allowed to re-post only once for free';
                            }
                          
                             return $this->returnData('msg', $msg);
                        }
                        $auction->update([
                            'end_date'=>NULL,
                            'repost'=>1,
                            'status'=>0,
                        ]);
                    
                                                    
                            if(app()->getLocale() == 'ar'){
                                 $msg = $appSettings->after_acution_ar;
                            }else{
                                 $msg = $appSettings->after_acution_en;
                            }
            
                            return $this->returnData('msg',$msg);
                    }
                    
                     return $this->returnData('msg', 'Not Found Auction');
       }
    
       public function test_corn(){
            $current        = Carbon::today()->toDateString();
            $current_time   =  Carbon::today()->toDateTimeString();
            
            $data = Auctions::withTrashed()->where('end_date','<=',Carbon::now())->where('owner_id',0)->where('status',1)->get(); 
           


    }
    
    public function paid_to_show_last_user_auction(Request $request){
         
           $token = $request->bearerToken();
                $user_id = $this->getUserID($token);  
                if(!is_numeric($user_id)){
                    return $user_id;
                }
        
        
         if(isset($request->paymentmethod)){
           if($request->paymentmethod == 2){   // wallet
              
                 $rules=[
                            'auction_id'        =>  'required|integer|exists:auctions,id',
                       ];
                       
                       
                       $valdaitor=Validator::make($request->all(),$rules);
                       if ($valdaitor->fails()){
                           $code=$this->returnCodeAccordingToInput($valdaitor);
                           return $this->returnValidationError($code,$valdaitor);
                       }else{
                          
                           $auction = Auctions::find($request->auction_id);
                            if(!$auction){
                                 return $this->returnData('msg', 'Not Found Auction');
                            }
                             //   ------------Check mony Of Wallet ----------------------------------------
                                     $amount=users_wallet::where('user_id',$user_id)->sum('money');
                                    
                            // ---------------------------------------------------------------------------
                            // echo $amount;die;
                            if($amount >= 1){
                                
                                                   users_wallet::create([
                                                            'user_id'=> $user_id,
                                                            'money'=>  -1 ,
                                                            'auction_id'=> $auction->id,
                                                            'comment'=> 'اظهار اخر مزايده على المزاذ ',
                                                     ]);
                                        
                                                   bills::create([
                                                        'user_id'=> $user_id,
                                                        'price'=> 1  ,
                                                        'product'=> $auction->name  ,
                                                        'product_id'=> $auction->id,
                                                        'name_ar'=> 'اظهار اخر مزايده على المزاد الخاص بك',
                                                        'name_en'=> 'Show the last bid on your auction',
                                                        'type'  => 2,
                                                        'payment_method'=> 'Wallet',
                                                    ]);
                                                    
                                                    $auction->update(['show_last_bid'=>1]);
                                
                                          
                                  $check =   Monthly_withdrawals::where('month', 'like', '%' . Carbon::now()->format('Y-m') . '%' )->count();
                                  
                                  if($check > 0){
                                        if (app()->getLocale() == 'ar') {
                                                $msg = 'تهانينا لك دخلت السحب الشهرى';
                                        }else{
                                                $msg = 'Congratulations, you entered the monthly draw';
                                        }
                                  }
                                  
                                      if (app()->getLocale() == 'ar') {
                                              $msg = 'تم الدفع بنجاح';
                                      } else {
                                             $msg = 'Payment completed successfully';
                                        }
                         
                                 return $this->returnData('msg',$msg);
                                 
                            }else{
                                              if (app()->getLocale() == 'ar') {
                                                            return $this->returnData('status',false, 'لا يوجد لديك رصيد كافى فى المحفظه');
                                                     } else {
                                                         return $this->returnData('status',false, 'You dont have enough wallet balance');
                                                        }  
                            }
                           
                        
                     
                       }
                       
          }elseif($request->paymentmethod == 3){                     // api charge
              
                 $rules=[
                         
                             'auction_id'           =>          'required|integer|exists:auctions,id',
                             'trans_id'             =>         'required',
                       ];
                 
                       
                       $valdaitor=Validator::make($request->all(),$rules);
                       if ($valdaitor->fails()){
                           $code=$this->returnCodeAccordingToInput($valdaitor);
                           return $this->returnValidationError($code,$valdaitor);
                       }else{
                                          
                                                     bills::create([
                                                                'user_id'=> $user_id,
                                                                'price'=> 1 ,
                                                                'product'=> $auction->name  ,
                                                                'product_id'=> $auction->id,
                                                                'name_ar'=> 'اظهار اخر مزايده على المزاد الخاص بك',
                                                                'name_en'=> 'Show the last bid on your auction',
                                                                'type'  => 2,
                                                                'payment_method'=> 'Online payment',
                                                    ]);
                                
                                                     $auction->update(['show_last_bid'=>1]);
                                     
                                          
                                      $check =   Monthly_withdrawals::where('month', 'like', '%' . Carbon::now()->format('Y-m') . '%' )->count();
                                      
                                      if($check > 0){
                                            if (app()->getLocale() == 'ar') {
                                                    $msg = 'تهانينا لك دخلت السحب الشهرى';
                                            }else{
                                                    $msg = 'Congratulations, you entered the monthly draw';
                                            }
                                      }
                                      
                                      
                                      if (app()->getLocale() == 'ar') {
                                              $msg = 'تم الدفع بنجاح';
                                      } else {
                                             $msg = 'Payment completed successfully';
                                        }
                         
                                 return $this->returnData('msg',$msg);
                         
                       
                     
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
    
       public function filtration(Request $request){
         
                $current_date = Carbon::now()->format("Y-m-d");
                
                $data = Auctions::where('status',1)->where('end_date','>=',$current_date);
               
  
                   
                 
                    if ($request->has('cat')){
                        $cates = Catgories::where('parent_id',$request->cat)->get(['id']);
                        $child_cat = [];
                        foreach($cates as $cate){
                            $child_cat[] = $cate->id;
                        }
                      $dat['child'] = $child_cat;
                      $dat['cat'] = $request->cat;
                       
                       $data->where(function ($q) use ($dat) {
                                  $q->whereIn('cat_id',$dat['child'])
                                    ->orwhere('cat_id',$dat['cat']);
                                });
                    }
                   
                   
                   if ($request->has('area')){
                       $data->where('place_id',$request->area);
                   }
                   
                   if ($request->has('filter_id')){

                       $products = category_item_products::where('type',1)->whereIn('category_item_id',$request->filter_id)->pluck('product_id')->toArray();
                       
                       $data->WhereIn('id',$products);

                   }
                   
                   
                    if ($request->has('sub_filter_id')){
                        
                       $products = [];
                       $products = category_item_products::where('type',1)->whereIn('category_item_component_id',$request->sub_filter_id)->pluck('product_id')->toArray();
                       
                     
                       $data->WhereIn('id',$products);

                        
                   }
                   
                   if ($request->has('text')){
                       $products = [];
                      
                       foreach($request->text as $text){
                          
                            $products[] = category_item_products:: where('type',1)->where('text', 'like', '%'.$text.'%')->pluck('product_id')->toArray();
                           
                       }
                      
                       $data->WhereIn('id',$products);
                   }

                $data       =  $all_data->orderBy('id','DESC')->get();
                
               
            if(count($data) > 0 ){
                
                
                $resource=singleAuctionResources::collection($data);
                return $this->returnData('auctions', $resource); 

                  
                  
            }else{
                 return $this->returnData('msg', 'Not Found Data');
            }
         }
    
    
}
