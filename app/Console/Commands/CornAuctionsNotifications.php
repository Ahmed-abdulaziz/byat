<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use App\Traits\notifcationTrait;
use App\Traits\imageTrait;
use App\Auctions;
use App\AuctionImages;
use App\auction_users;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\depoist_payment_users;
use App\Notifications;
class CornAuctionsNotifications extends Command
{
    use GeneralTrait;
    use notifcationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AuctionsNotifications:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
           DB::table('cornjob_table_test')->insert([
            'name' => 'Ahmed Abdulaziz test corn job CornAuctionsNotifications',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

          //   ------------------------------Check Expired Auctions-----------------------------------------------
         $data = Auctions::withTrashed()->where('status',1)->get(); 
         foreach($data as $item){
                                            $nowDate = Carbon::now();
                                            $check_date_of_auction = $nowDate->gt($item->end_date);
                                            
                                             if($check_date_of_auction && $item->status == 1){
                                                 
                                                    $check_count = auction_users::where('auction_id',$item->id)->count();
                                                    
                                                    // if($check_count > 0){
                                                    //     $last_user = auction_users::where('auction_id',$item->id)->latest()->first();
                                                    //       $allpayment = depoist_payment_users::where('auction_id',$item->id)->where('user_id','!=',$last_user->user_id)->get();
                                                    //         foreach($allpayment as $payment){
                                                    //               $resource=$this->back_users_deposit($payment);
                                                    //               $payment->update([
                                                    //                     'status'=> 1,
                                                    //                 ]);
                                                                    
                                                                    
                                                    //                   $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$payment->user_id)->value('token');
                                                    //                      $msg = "عفوا لقد اغلق المزاد الذى زايدت عليه";
                                                    //                         if(!empty($fcmtoken)){
                                                                               
                                                    //                                 $this->pushNotification([  
                                                    //                                     'order_id' => null,
                                                    //                                     'title'=> 'laytwfk' ,
                                                    //                                     'body'=> "$msg",
                                                    //                                     'click_action'=> "ACTION_NORMAL" ,
                                                    //                                     'device_token' => [$fcmtoken],
                                                    //                                     'id'=> null
                                                    //                                 ]);
                                                                            
                                                                    
                                                    //                         }
                                                                            
                                                    //                           Notifications::create([
                                                    //                                 'msg'=> $msg,
                                                    //                                 'title'=> 'laytwfk',
                                                    //                                 'user_id'=> $payment->user_id,
                                                    //                                 'product_id'=> $item->id,
                                                    //                                 'type' => 1
                                                    //                          ]);
                                                    //         }
                                                    //          $item->update([
                                                    //             'status'=> 2,
                                                    //             'owner_id'=>$last_user->user_id,
                                                    //         ]);
                                                
                                                    //                     $winner = appUsers::find($last_user->user_id);
                                                    //                   $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$last_user->user_id)->value('token');
                                                    //                         $msg =  " مبروك. لقد رسى عليك المزاد";
                                                    //                         if(!empty($fcmtoken)){
                                                                               
                                                    //                                 $this->pushNotification([  
                                                    //                                     'order_id' => null,
                                                    //                                     'title'=> 'laytwfk' ,
                                                    //                                     'body'=> "$msg",
                                                    //                                     'click_action'=> "ACTION_NORMAL" ,
                                                    //                                     'device_token' => [$fcmtoken],
                                                    //                                     'id'=> null
                                                    //                                 ]);
                                                                            
                                                                    
                                                    //                         }
                                                                            
                                                    //                           Notifications::create([
                                                    //                                 'msg'=> $msg,
                                                    //                                 'title'=> 'laytwfk',
                                                    //                                 'user_id'=> $last_user->user_id,
                                                    //                                 'product_id'=> $item->id,
                                                    //                                 'type' => 1
                                                    //                          ]);
                                                                             
                                                                                                                                                          
                                                    //                               $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$item->user_id)->value('token');
                                                                                              
                                                    //                                     $msg = " لقد رسى المزاد الخاص بك على 
                                                    //                                     ".$winner->name;
                                                    //                                         if(!empty($fcmtoken)){
                                                                                    
                                                    //                                                 $this->pushNotification([  
                                                    //                                                     'order_id' => null,
                                                    //                                                     'title'=> 'laytwfk' ,
                                                    //                                                     'body'=> "$msg",
                                                    //                                                     'click_action'=> "ACTION_NORMAL" ,
                                                    //                                                     'device_token' => [$fcmtoken],
                                                    //                                                     'id'=> null
                                                    //                                                 ]);
                                                                                            
                                                                                    
                                                    //                                         }
                                                                                            
                                                    //                                       Notifications::create([
                                                    //                                             'msg'=> $msg,
                                                    //                                             'title'=> 'laytwfk',
                                                    //                                             'user_id'=> $item->user_id,
                                                    //                                             'product_id'=> $item->id,
                                                    //                                             'type' => 1
                                                    //                                      ]);
                                                                                    
                
                                                    // }else{
                                                 
                                                    //  $item->update([
                                                    //     'status'=> 3,
                                                    // ]);
                                                
                                                        //   $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$item->user_id)->value('token');
                                                                                              
                                                        //              $msg = "تم أنتهاء وقت مزاد   $item->name " ;
                                                        //             if(!empty($fcmtoken)){
                                                            
                                                        //                     $this->pushNotification([  
                                                        //                         'order_id' => null,
                                                        //                         'title'=> 'laytwfk' ,
                                                        //                         'body'=> "$msg",
                                                        //                         'click_action'=> "ACTION_NORMAL" ,
                                                        //                         'device_token' => [$fcmtoken],
                                                        //                         'id'=> null,
                                                        //                         'type'=>1
                                                        //                     ]);
                                                                    
                                                            
                                                        //             }
                                                                    
                                                        //           Notifications::create([
                                                        //                 'msg'=> $msg,
                                                        //                 'title'=> 'laytwfk',
                                                        //                 'user_id'=> $item->user_id,
                                                        //                 'product_id'=> $item->id,
                                                        //                 'type' => 1
                                                        //          ]);
                                                    // }
                                             }
         }            
                                    //------------------------------------------------------------------------------------------------- 
       
    
    }
}
