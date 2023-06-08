<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Advertisments;
use App\Models\appUsers;
use App\Models\Packages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\appuser_requirments;
use App\Traits\notifcationTrait;
use App\Notifications;
use App\Traits\GeneralTrait;
use App\codes;
use App\users_wallet;
use App\Traits\imageTrait;
use App\bills;
use App\cash_payment_requests;
use Carbon\Carbon;
use App\packages_subscription;
class appUserController extends Controller
{
    use notifcationTrait;
     use GeneralTrait;
     use imageTrait;
    public function index(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('read_appusers'), 403);
         
        $Bankacounts = appUsers::get();

        return view('dashboard.appuser.index', compact('Bankacounts'));

    }


    public function create()
    {
               abort_if(!auth()->user()->hasPermission('create_appusers'), 403);
         
              return view('dashboard.appuser.add');
    }
    
    public function cash_payment_requests(){
        abort_if(!auth()->user()->hasPermission('cash_payment_requests'), 403);
        
         $data = cash_payment_requests::where('status',0)->orderBy('id','DESC')->get();
         return view('dashboard.cash-payment-requests.index', compact('data'));
    }
    
       public function cash_request_status($id , $status){
        
        abort_if(!auth()->user()->hasPermission('cash_payment_requests'), 403);
        
         $payment=cash_payment_requests::find($id);
         if($payment && $payment->status == 0){
              if($status == 2){        // disapprove
                 $payment->update([
                  'status' => 2
                 ]);
                 
                 
                           
                       $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$payment->user_id)->value('token');
                        $msg_en = "Your request to purchase a package by cash was rejected" ;
                        $msg_ar = "تم رفض طلبك لشراء باقه عن طريق الكاش" ;
                        $msg = ['ar' => $msg_ar , 'en' => $msg_en][app()->getLocale()];

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
                                'user_id'=>$payment->user_id,
                                'product_id'=> 0,
                                'type' => 0,
                         ]);
                         
             }elseif($status == 1){
                 
                 
                    $main_package = Packages::find($payment->product_id);
                           if($main_package){
                    
                                        $user = appUsers::find($payment->user_id);
                                                    $old_adv = $user->adv_number;
                                                     $total = $old_adv + $main_package->adv_num;
                                        $last = packages_subscription::create([
                                                    'user_id' => $payment->user_id,
                                                    'package_id' => $payment->product_id,
                                                    'type' =>  $payment->type ,
                                                    'adv_id' => $payment->adv_id,
                                                    
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
                                                        'user_id'=> $payment->user_id,
                                                        'price'=> $main_package->price  ,
                                                        'product'=> $last->type == 2 ? $adv->name : NULL  ,
                                                        'product_id'=> $adv->id,
                                                        'name_ar'=> $name_ar,
                                                        'name_en'=> $name_en,
                                                        'package'=> $main_package->name,
                                                        'payment_method'=> 'Cash',
                                                    ]);
                                        
                                            $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$payment->user_id)->value('token');
                                            $msg_en = "Your request to purchase a package by cash has been accepted" ;
                                            $msg_ar = "تم قبول طلبك لشراء باقه عن طريق الكاش" ;
                                            $msg = ['ar' => $msg_ar , 'en' => $msg_en][app()->getLocale()];
                    
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
                                                    'user_id'=>$payment->user_id,
                                                    'product_id'=> 0,
                                                    'type' => 0,
                                             ]);
                                                                        
                                         $payment->update([
                                          'status' => 1
                                         ]);
                                         
                 
                 
             }
               session()->flash('success', __('site.updated_successfully'));
         }
        
         }
            
      
        return redirect()->back();
    }
    
    
    public function change_status($id , $status){
        
         abort_if(!auth()->user()->hasPermission('active_appusers'), 403);
         
         $user=appUsers::find($id);
          $user->update([
              'status' => $status
             ]);
             if($status != 1){
                 $user->update([
                  'api_token' => NULL
                 ]);
             }
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.appuser.index');
    }
    public function change_user_requirments($id , $status){
        
         abort_if(!auth()->user()->hasPermission('app-user-requirments'), 403);
         
         $requirments= appuser_requirments::find($id);

         if($status == 1){
              $user=appUsers::find($requirments->user_id);
              if($requirments->type == 1){   // name
                  $user->update([
                      'name'=>$requirments->change,
                    ]);
                    
                    $requirments->update([
                      'status'=>$status,
                    ]);
              }
         }elseif($status == 2){
               $requirments->update([
                      'status'=>$status,
                    ]);
         }
         
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.app-user-requirments');
    }

    public function store(Request $request)
    {
           abort_if(!auth()->user()->hasPermission('create_appusers'), 403);
            $validated = $request->validate([
                        'name' => 'required',
                        'phone' => 'required|unique:app_users,phone',
                        'password' => 'required',
                ]);
     
                if(!empty($request->email)){
                     $check_email = appUsers::where('email',$request->email)->count();
                        if($check_email > 0){
                            return redirect()->back()->withErrors( __('site.email is exist'))->withInput();
                        } 
                }
               
            
             $advfree = DB::table('app_settings')->where('id', '=', 1)->value('free_adv');
                $free_auctions = DB::table('app_settings')->where('id', '=', 1)->value('free_auctions');
               if ($request->has('img')){
                   $imageName = $this->storeImages($request->img, $this->main_path().'uploads/user_images/');
               }else{
                   $imageName='def.png';
               }

            $appuser = appUsers::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'provider_id'       => $request->provider_id,
                'img'               => $imageName,
                'adv_number'        => $advfree,
                'auctions_number'   => $free_auctions,
                'password'          => bcrypt($request->password),
            ]);//create user
            
            
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.appuser.index');
    }



    public function user_requirments()
    {
         abort_if(!auth()->user()->hasPermission('app-user-requirments'), 403);

        $requirments=appuser_requirments::where("status",0)->orderBy('created_at','DESC')->get();
        return view('dashboard.appuser.requirment', compact('requirments'));

    }




    public function show($appUsers)
    {

        $catgory=Packages::all()->where('type',1);
        $Bankacounts = Advertisments::where('user_id',$appUsers)->where('active','=',1)->latest()->paginate(5);
        return view('dashboard.appuser.advindex', compact('Bankacounts','catgory'));

    }


    public function edit($appUsers)
    {
       
         
        return view('dashboard.appuser.update',compact('appUsers'));
    }


         public function add_balance_to_wallet(Request $request,$appUsers){
             
               abort_if(!auth()->user()->hasPermission('Adding_balance_to_appusers_wallet'), 403);
               
              $request->validate([
                        'money'=>'required',
                ]);

                $money = $request->money;
                
                 users_wallet::create([
                                'user_id'=>$appUsers,
                                'money'=>$money,
                                'comment'=>'شحن من الادمن',
                                'amount'=>$money
                            ]);
                            
                            
                 $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$appUsers)->value('token');
                            $msg = "تم اضافة رصيد لمحفظتك بقيمة \n $money دينار";
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
                                'user_id'=>$appUsers,
                                'product_id'=> 0,
                                'type' => 3,
                         ]);
                
                    session()->flash('success', __('site.sent succesfully'));
                    return redirect()->back();
             
         }
         
         
         public function add_number_adv_free(Request $request,$appUsers){
             
              abort_if(!auth()->user()->hasPermission('Add_number_of_free_ads_to_appusers'), 403);
              
              
              $request->validate([
                        'number'=>'required',
                ]);
                    
                    
                    $number = $request->number;
                    $user =  appUsers::find($appUsers);
                    if($user){
                        $user->update(['adv_number'=>$user->adv_number + $number]);
                    }
                            
                 $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$appUsers)->value('token');
                            $msg = "تم اضافة عدد $number اعلانات مجانيه لك";
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
                                'user_id'=>$appUsers,
                                'product_id'=> 0,
                                'type' => 0,
                         ]);
                
                    session()->flash('success', __('site.sent succesfully'));
                    return redirect()->back();
             
         }
         
        public function send_recharge_card(Request $request,$appUsers){
            
             abort_if(!auth()->user()->hasPermission('send_recharge_card_to_appusers'), 403);
             
                 $request->validate([
                        'code'=>'required',
                ]);
                $code = $request->code;   
                $check = codes::where('code',$code)->first();
                if(!$check){
                      session()->flash('errormsg',  __('site.code not found'));
                      return redirect()->back();
                }
                if(!empty($check->user_id)){
                     session()->flash('errormsg',  __('site.code used before'));
                     return redirect()->back();
                }
                 
                    $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$appUsers)->value('token');
                            $msg = "جالك كارت لشحن رصيد من التطبيق   \n كود الشحن";
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
                                'user_id'=>$appUsers,
                                'product_id'=> 0,
                                'type' => 3,
                                'code' => $code
                         ]);
                
                    session()->flash('success', __('site.sent succesfully'));
                    return redirect()->back();
                
        }
    public function update(Request $request,$appUsers)
    {
        $request->validate([
            'adv_number'=>'required'
        ]);
       $date=$request->except('_token');


          $update=appUsers::find($appUsers);

        $update->update($date);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.appuser.index');

    }


    public function destroy($appUsers)
    {
         abort_if(!auth()->user()->hasPermission('delete_AppUsers'), 403);
         
        $appuser=appUsers::destroy($appUsers);
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.appuser.index');
    }
}
