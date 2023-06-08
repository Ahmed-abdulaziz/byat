<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use App\Auctions;
use App\AuctionImages;
use App\auction_users;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\depoist_payment_users;
use App\Traits\notifcationTrait;
use App\Notifications;
use App\Models\appUsers;
class Auctions_time extends Command
{
     use GeneralTrait;
    use notifcationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AuctionsTime:cron';

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
            'name' => 'Ahmed Abdulaziz test corn job Auctions Time',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
            $current        = Carbon::today()->toDateString();
            $current_time   =  Carbon::today()->toDateTimeString();
            
              $data = Auctions::withTrashed()->where('end_date','<=',Carbon::now())->where('owner_id',0)->where('status',1)->get(); 
              foreach($data as $item){
                
                   $time = Carbon::parse($item->end_date)->format('H:i:s');
                   if($current_time >= $time){
                     
                      $item->update(['status'=> 3]);                   // Time Is Out
                       
                    //   Get user Auction--------
                    
                            $users_count = auction_users::where('auction_id',$item->id)->count();
                           
                            if($users_count > 0){   
                                 // users is auction
                                 
                                $maximum_amount_count = auction_users::where('auction_id',$item->id)->where('price' , '>=',$item->maximum_amount)->count();
                                    if($maximum_amount_count > 0){           // users arrive to maximum  price
                                       
                                                   $winner_user = auction_users::where('auction_id',$item->id)->where('price' , '>=',$item->maximum_amount)->orderBy('price','DESC')->first();
                                                   $winner      =    appUsers::find($winner_user->user_id);                                                                        
                                                          $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$item->user_id)->value('token');
                                                                      
                                                                $msg = " لقد رسى المزاد الخاص بك على 
                                                                ".$winner->name;
                                                                    if(!empty($fcmtoken)){
                                                            
                                                                            $this->pushNotification([  
                                                                                'order_id' => null,
                                                                                'title'=> 'Laytwfk App' ,
                                                                                'body'=> "$msg",
                                                                                'click_action'=> "ACTION_NORMAL" ,
                                                                                'device_token' => [$fcmtoken],
                                                                                'id'=> null,
                                                                                'type'=> null
                                                                            ]);
                                                                    
                                                            
                                                                    }
                                                                    
                                                                  Notifications::create([
                                                                        'msg'=> $msg,
                                                                        'title'=> 'Laytwfk App',
                                                                        'user_id'=> $item->user_id,
                                                                        'product_id'=> $item->id,
                                                                        'type' => 5
                                                                 ]);
                                                                 
                                                        // -----------------------------
                                                        
                                                        //   $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$winner->id)->value('token');
                                                                      
                                                        //         $msg = "مبروك لقد رسى المزاد عليك"; 
                                                        //             if(!empty($fcmtoken)){
                                                            
                                                        //                     $this->pushNotification([  
                                                        //                         'order_id' => null,
                                                        //                         'title'=> 'Laytwfk App' ,
                                                        //                         'body'=> "$msg",
                                                        //                         'click_action'=> "ACTION_NORMAL" ,
                                                        //                         'device_token' => [$fcmtoken],
                                                        //                         'id'=> null,
                                                        //                         'type'=> null
                                                        //                     ]);
                                                                    
                                                            
                                                        //             }
                                                                    
                                                        //           Notifications::create([
                                                        //                 'msg'=> $msg,
                                                        //                 'title'=> 'Laytwfk App',
                                                        //                 'user_id'=> $winner->id,
                                                        //                 'product_id'=> $item->id,
                                                        //                 'type' => 1
                                                        //          ]);
                            
                                    }else{
                                        
                                                                                                            
                                                          $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$item->user_id)->value('token');
                                                                      
                                                                $msg = "لقد انقضت مدة مزادك ولم يزايد احد بالمبلغ المطلوب";
                                                                    if(!empty($fcmtoken)){
                                                            
                                                                            $this->pushNotification([  
                                                                                'order_id' => null,
                                                                                'title'=> 'Laytwfk App' ,
                                                                                'body'=> "$msg",
                                                                                'click_action'=> "ACTION_NORMAL" ,
                                                                                'device_token' => [$fcmtoken],
                                                                                'id'=> null,
                                                                                'type'=> null
                                                                            ]);
                                                                    
                                                            
                                                                    }
                                                                    
                                                                  Notifications::create([
                                                                        'msg'=> $msg,
                                                                        'title'=> 'Laytwfk App',
                                                                        'user_id'=> $item->user_id,
                                                                        'product_id'=> $item->id,
                                                                        'type' => 6
                                                                 ]);
                                                                 
                                    }
                            }else{
                                
                                              $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$item->user_id)->value('token');
                                                                      
                                                                $msg = "لقد انقضت مدة مزادك ولم يزايد احد  ";
                                                                    if(!empty($fcmtoken)){
                                                            
                                                                            $this->pushNotification([  
                                                                                'order_id' => null,
                                                                                'title'=> 'Laytwfk App' ,
                                                                                'body'=> "$msg",
                                                                                'click_action'=> "ACTION_NORMAL" ,
                                                                                'device_token' => [$fcmtoken],
                                                                                'id'=> null,
                                                                                'type'=> null
                                                                            ]);
                                                                    
                                                            
                                                                    }
                                                                    
                                                                  Notifications::create([
                                                                        'msg'=> $msg,
                                                                        'title'=> 'Laytwfk App',
                                                                        'user_id'=> $item->user_id,
                                                                        'product_id'=> $item->id,
                                                                        'type' => 7
                                                                 ]);
                                                                 
                            }
                       
                   }
                       
                   
             
            }

    }
}
