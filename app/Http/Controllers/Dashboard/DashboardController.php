<?php

namespace App\Http\Controllers\Dashboard;

use App\Vistoer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Auctions;
use App\Balance_recovery;
use App\auction_users;
use App\depoist_payment_users;
use App\Traits\GeneralTrait;
use App\Models\appUsers;
use App\users_wallet;
use App\Advertisments;
use App\updateadv;
use App\Models\Messages;
use App\Traits\notifcationTrait;
use App\Notifications;
use App\Models\Catgories;
class DashboardController extends Controller
{
     use GeneralTrait;
     use notifcationTrait;
    public function index()
    {
        
        $all_data = Auctions::where('status','!=',0)->where('status','=',1)->get();
            if(count($all_data) > 0){
                      foreach( $all_data as $data){
                          
                            //   ------------------------------Check Expired Auctions-----------------------------------------------
                           
                                            $nowDate = Carbon::now();
                                            $check_date_of_auction = $nowDate->gt($data->end_date);
                                            
                                             if($check_date_of_auction && $data->status == 1){
                                                 
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
                                                             $data->update([
                                                                'status'=> 2,
                                                                'owner_id'=>$last_user->user_id,
                                                            ]);
                                                
                                                            
                                                    }else{
                                                 
                                                     $data->update([
                                                        'status'=> 3,
                                                    ]);
                                                
                                                      
                                                    }
                                             }
                             
                                    //------------------------------------------------------------------------------------------------- 
                                    
                          
                          //   ------------------------------Check Expired Auctions-----------------------------------------------
                                            // $main_auctions = Auctions::find($data->id);
                                            // $nowDate = Carbon::now();
                                            // $check_date_of_auction = $nowDate->gt($main_auctions->end_date);
                                            
                                            //  if($check_date_of_auction && $main_auctions->status == 1){
                                                 
                                            //          $main_auctions->update([
                                            //             'status'=> 3,
                                            //         ]);
                                                
                                            //  }
                             
                                    //------------------------------------------------------------------------------------------------- 
                                    
                      }
                
            }

        $dailayusers=DB::table('app_users')->whereDate('created_at','=',Carbon::today())->count();
        $allsuers = appUsers::count();
        $advertisments = Advertisments::count();
        $Auctions = Auctions::count();
        $total_wallet = users_wallet::sum('money');
        $total_package = users_wallet::where('comment','شحن باقه')->sum('money') * -1 ;
        // $visits=DB::table('app_users')->count();
        // $advcount=DB::table('advertisments')->whereDate('created_at','=',Carbon::today())->count();
        $dailpayment=DB::table('user__payments')->whereDate('created_at','=',Carbon::today())->sum('total');
        $dailpayment2=DB::table('user__payments')->where('type',2)->whereDate('created_at','=',Carbon::today())->sum('total');
        
        $visits =Vistoer::whereDate('created_at','=',Carbon::today())->first();
        
        $advertismentsnoactive = Advertisments::where('status',0)->count();
        $Auctionsnoactive = Auctions::where('status',0)->count();
        $updateadvcount = updateadv::where('status' , 0)->count();

        $Auctionend = Auctions::where('end_date','<',Carbon::now())->count();
        $complines = Messages::where('status',0)->where('type',0)->count();
        $suggestions = Messages::where('status',0)->where('type',1)->count();

        return view('dashboard.index',compact('complines','suggestions','dailayusers','dailpayment' , 'Auctionend' , 'Auctions' , 'total_wallet'  ,'allsuers' , 'total_package' , 'advertisments','visits','dailpayment2' , 'advertismentsnoactive' , 'Auctionsnoactive','updateadvcount'));
    }//end of index


    public function getsubarea(Request $request){
        $subcat=DB::table('areas')->where('city_id','=',$request->id)->get();
        return response()->json($subcat);
    }
    
    public function getsubmodel(Request $request){
        $subcat=DB::table('models')->where('brand_id','=',$request->id)->get();
        return response()->json($subcat);
    }
    
     public function showBalance_recovery(Request $request){
        //  
         abort_if(!auth()->user()->hasPermission('Balance_recovery'), 403);
            $type = $request->type;
            
            $data=Balance_recovery::where('status',$type)->orderBy('created_at','DESC')->get();

            return view('dashboard.balance-recovery.index',compact('data','type'));
    }
    
      public function restBalance_recovery($id){
           abort_if(!auth()->user()->hasPermission('Balance_recovery'), 403);
         $Balance =  Balance_recovery::where('id',$id)->where('status',0)->first();
       
           if($Balance){
                $User = appUsers::find($Balance->user_id);
                $amount=users_wallet::where('user_id',$User->id)->sum('money');
                if($amount > 0){
                      users_wallet::create([
                        'user_id'=> $User->id,
                        'money'=>  $amount *-1,
                        'comment' => 'أسترجاع رصيد',
                    ]);
                    
                       $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$User->id)->value('token'); 
                                      
                
                        $msg_en = "Your balance of Dinar $amount has been successfully recovered" ;
                        $msg_ar = "تم استرجاع الرصيد الخاص بكم بنجاح بقيمة $amount  دينار" ;
                        $msg = ['ar' => $msg_ar , 'en' => $msg_en][app()->getLocale()];
                        
                            if(!empty($fcmtoken)){
             
                                
                                $this->pushNotification([  
                                    'order_id' => null,
                                    'title'=> 'laytwfk' ,
                                    'body'=> $msg,
                                    'click_action'=> "ACTION_NORMAL" ,
                                    'device_token' => [$fcmtoken],
                                    'id'=> 0,
                                    'type'=>'auction'
                                ]);
                            } 
                                Notifications::create([
                                    'msg'=> $msg,
                                    'title'=> 'laytwfk',
                                    'user_id'=> $User->id,
                                    'product_id'=> 0,
                                    'type' => 3
                             ]);
                        
                       
                        
                    $Balance->update(['status'=>1,'balance'=>$amount ]);
                }
              
               
           }
             return redirect()->route('dashboard.Balance_recovery',['type'=>0]);
    }
    
    
    
    public function Balance_list(){
          abort_if(!auth()->user()->hasPermission('app_reports'), 403);
          
        $datas=users_wallet::groupBy('user_id')
                       ->selectRaw('sum(money) as total , user_id')
                       ->get();

            $recoverys = [];
            foreach($datas as $recovery){
                
                $User = appUsers::find($recovery->user_id);
                if($User){
                       $recovery->amount=$recovery->total;
                       $recovery->user_name = $User->name;
                       $recovery->user_phone=$User->phone;
                      $recoverys[] = $recovery;
                }
          
            }
       return view('dashboard.balance-recovery.Balance-list',compact('recoverys'));
    }
    
    
       public function wallet_reports(){
           
             abort_if(!auth()->user()->hasPermission('app_reports'), 403);
             
        $datas=users_wallet::whereNotNull("code")->get();

            $recoverys = [];
            foreach($datas as $recovery){
                
                $User = appUsers::find($recovery->user_id);
                if($User){
                       $recovery->amount=$recovery->money;
                       $recovery->user_name = $User->name;
                       $recovery->user_phone=$User->phone;
                       $recovery->code=$recovery->code;
                       $recovery->date=$recovery->created_at;
                      $recoverys[] = $recovery;
                }
          
            }
       return view('dashboard.balance-recovery.wallet-reports',compact('recoverys'));
    }
    
    public function  get_sub_catgories(Request $request){
        $data=Catgories::where('active','=',1)->where('parent_id','=',$request->cat_id)->orderBy('ordered','ASC')->get();
             if($data){
                         return view('dashboard.catgoires.ajax.sub_catgories', compact('data'));
                }
            return '';
            
     }
      public function  check_examination_certificate(Request $request){
        $data=Catgories::find($request->cat_id);
        if($data){
                        return $data->examination_image;    // 	0-not required 1-required	
                }
            return 0;
            
     }

}//end of controller
