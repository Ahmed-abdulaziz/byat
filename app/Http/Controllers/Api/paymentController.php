<?php

namespace App\Http\Controllers\Api;

use App\Models\Messages; 
use App\Traits\GeneralTrait;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Packages;
use App\Models\appUsers;
use App\Models\appSettings;
use App\Advertisments;
use Carbon\Carbon;
use App\Auctions;
use App\bills;
use App\packages_subscription;
use App\Monthly_withdrawals;
use App\payments;
use App\depoist_payment_users;
class paymentController extends Controller
{
    use GeneralTrait;
    public function payment(Request $request){
      
      
         
    
            $appSettings = appSettings::first();
            $user = appUsers::find($request->user_id);
            if(!$user){
                  if (app()->getLocale() == 'ar') {
                        return $this->returnData('status',false, 'هذا العميل غير موجود');
                    } else {
                      return $this->returnData('status',false, 'User Not Found');
                    }
            }
            if($request->doing == 'buy_package'){
                
                $package = Packages::find($request->package_id);
                if($package){
                    $price = $package->price;
                }else{
                    if (app()->getLocale() == 'ar') {
                        return $this->returnData('status',false, 'هذه الباقه غير موجوده');
                    } else {
                      return $this->returnData('status',false, 'Package Not Found');
                    }
                }
                $adv_id = $request->adv_id;         // if star
                if(!empty($adv_id)){
                    $Advertisments = Advertisments::find($adv_id);
                    if(!$Advertisments){
                         if (app()->getLocale() == 'ar') {
                                 return $this->returnData('status',false, 'هذا الاعلان غير موجود');
                            } else {
                              return $this->returnData('status',false, 'Advertisment Not Found');
                            }
                    }
                }
                $data = ['doing'=> 'package'  ,'package_id'=>$request->package_id , 'adv_id'=> $request->adv_id, 'user_id'=> $request->user_id ];
                
            }elseif($request->doing == 'auction_insurance'){
                
               
                $auction = Auctions::find($request->auction_id);
                if($auction){
                    $price = $auction->deposit_amount;
                }else{
                     if (app()->getLocale() == 'ar') {
                        return $this->returnData('status',false, 'هذا المزاد غير موجود');
                    } else {
                      return $this->returnData('status',false, 'Auction Not Found');
                    }
                }
               
                $data = ['doing'=> 'auction_insurance' ,'auction_id'=>$request->auction_id , 'user_id'=> $request->user_id ];
               
               
            }elseif($request->doing == 'pay_one_dinar'){

                   
                $auction = Auctions::find($request->auction_id);
                if($auction){
                    $price = 1;
                }else{
                     if (app()->getLocale() == 'ar') {
                        return $this->returnData('status',false, 'هذا المزاد غير موجود');
                    } else {
                      return $this->returnData('status',false, 'Auction Not Found');
                    }
                }
               
                $data = ['doing'=> 'pay_one_dinar' ,'auction_id'=>$request->auction_id , 'user_id'=> $request->user_id ];
        
            }
            
                   
           
            $api_key = "a3c220b5f12972bf18018d278586309b69f68aea"; // replace with your API key
            $api_key_encrypted = password_hash($api_key, PASSWORD_BCRYPT);


            $fields = array(
            'merchant_id'=>'3507',
             'username' => 'drcycle',
            'password'=>stripslashes('GJkXBXAe{@Zk'),
            'api_key'=>$api_key_encrypted, // in sandbox request
            //  'api_key' =>password_hash('API_KEY',PASSWORD_BCRYPT), //In production mode, please pass API_KEY with 
            'order_id'=>time(), // MIN 30 characters with strong unique function (like hashing function with time)
            'total_price'=>$price,
            'CurrencyCode'=> 'KWD',//only works in production mode
            'CstFName'=> $user->name,			
            'CstEmail'=>$user->email,
            'CstMobile'=>$user->phone,
            'success_url'=>route('api.paymentpackage' , $data),
            'error_url'=>route('home'),
            'test_mode'=>0, // test mode enabled
            'whitelabled'=>true, // only accept in live credentials (it will not work in test)
            'payment_gateway'=>$request->vtype == 4 ? 'knet' : 'cc',// only works in production mode
            );
            $fields_string = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/payment-request");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);
            $server_output = json_decode($server_output,true);
            
            // echo "<pre>";
            // print_r($server_output);
         
            
            
            if(!empty($server_output['paymentURL'])){
                $res['paymentURL'] = $server_output['paymentURL'];
                return $res;
            }else{
                return $server_output;
            }
           


            // E$ft0LY-Ta)C

    }

    public function payment_test(Request $request){
      
      
         
           
           
        // $api_key = "a3c220b5f12972bf18018d278586309b69f68aea"; // replace with your API key
        // $api_key_encrypted = password_hash($api_key, PASSWORD_BCRYPT);


        // $fields = array(
        // 'merchant_id'=>'3507',
        //  'username' => 'drcycle',
        // 'password'=>stripslashes('GJkXBXAe{@Zk'),
        // 'api_key'=>$api_key_encrypted, // in sandbox request
        //  //'api_key' =>password_hash('API_KEY',PASSWORD_BCRYPT), //In production mode, please pass API_KEY with 
        // 'order_id'=>time(), // MIN 30 characters with strong unique function (like hashing function with time)
        // 'total_price'=>'10',
        // 'CurrencyCode'=> 'KWD',//only works in production mode
        // 'CstFName'=>'Test Name',
        // 'CstEmail'=>'test@test.com',
        // 'CstMobile'=>'12345678',
        // 'success_url'=>route('api.paymentpackage'), 
        // 'error_url'=>'https://example.com/error.html', 
        // 'test_mode'=>0, // test mode enabled
        // 'whitelabled'=>true, // only accept in live credentials (it will not work in test)
        // 'payment_gateway'=>'knet',// only works in production mode
        // );
        // $fields_string = http_build_query($fields);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/payment-request");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
        // // receive server response ...
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $server_output = curl_exec($ch);
        // curl_close ($ch);
        // $server_output = json_decode($server_output,true);
        
        // // echo "<pre>";
        // // print_r($server_output);
        // header('Location:'.$server_output['paymentURL']);
        // exit;
        
        $appSettings = appSettings::first();
        $user = appUsers::find($request->user_id);
        if(!$user){
              if (app()->getLocale() == 'ar') {
                    return $this->returnData('status',false, 'هذا العميل غير موجود');
                } else {
                  return $this->returnData('status',false, 'User Not Found');
                }
        }
        if($request->doing == 'buy_package'){
            
            $package = Packages::find($request->package_id);
            if($package){
                $price = $package->price;
            }else{
                if (app()->getLocale() == 'ar') {
                    return $this->returnData('status',false, 'هذه الباقه غير موجوده');
                } else {
                  return $this->returnData('status',false, 'Package Not Found');
                }
            }
            $adv_id = $request->adv_id;         // if star
            if(!empty($adv_id)){
                $Advertisments = Advertisments::find($adv_id);
                if(!$Advertisments){
                     if (app()->getLocale() == 'ar') {
                             return $this->returnData('status',false, 'هذا الاعلان غير موجود');
                        } else {
                          return $this->returnData('status',false, 'Advertisment Not Found');
                        }
                }
            }
            $data = ['doing'=> 'package'  ,'package_id'=>$request->package_id , 'adv_id'=> $request->adv_id, 'user_id'=> $request->user_id ];
            
        }elseif($request->doing == 'auction_insurance'){
            
           
            $auction = Auctions::find($request->auction_id);
            if($auction){
                $price = $auction->deposit_amount;
            }else{
                 if (app()->getLocale() == 'ar') {
                    return $this->returnData('status',false, 'هذا المزاد غير موجود');
                } else {
                  return $this->returnData('status',false, 'Auction Not Found');
                }
            }
           
            $data = ['doing'=> 'auction_insurance' ,'auction_id'=>$request->auction_id , 'user_id'=> $request->user_id ];
           
           
        }elseif($request->doing == 'pay_one_dinar'){

               
            $auction = Auctions::find($request->auction_id);
            if($auction){
                $price = 1;
            }else{
                 if (app()->getLocale() == 'ar') {
                    return $this->returnData('status',false, 'هذا المزاد غير موجود');
                } else {
                  return $this->returnData('status',false, 'Auction Not Found');
                }
            }
           
            $data = ['doing'=> 'pay_one_dinar' ,'auction_id'=>$request->auction_id , 'user_id'=> $request->user_id ];
    
        }
        
        
        $api_key = "jtest123"; // replace with your API key
        $api_key_encrypted = password_hash($api_key, PASSWORD_BCRYPT);
        
      
            
        $fields=array(
            'merchant_id'=>'1201',
            'username' =>'test',
            'password'=>stripslashes('test'),
            'api_key' =>'jtest123',
            'order_id'=>time(),
            'CurrencyCode'=>'KWD',
            'total_price'=>$price,
            'CstFName'=> $user->name,			
            'CstEmail'=>$user->email,
            'CstMobile'=>$user->phone,
            'success_url'=>route('api.paymentpackage' , $data),
            'error_url'=>route('api.payment'),
            'notifyURL'=>route('api.payment'),
            'test_mode'=>1,
        );
        
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/test-payment");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $server_output = json_decode($server_output,true);
        
        // echo "<pre>";
        // print_r($server_output);
        // header('Location:'.$server_output['paymentURL']);
        // exit;
             
        $res['paymentURL'] = $server_output['paymentURL'];
        return $res;


        // E$ft0LY-Ta)C

}

    public function paymentpackage(Request $request){

        // return  $request;

        // Customiz Request -----------------

        // https://development.lay6ofk.com/api/payment_error?doing=package&package_id=30&user_id=12?PaymentID=101202312187250042.......................
        // to
        // https://development.lay6ofk.com/api/payment_error?doing=package&package_id=30&user_id=12&PaymentID=101202312187250042.......................
           
            $request['user_id'] = str_replace("?", "&", $request->user_id);

            $position = strpos( $request['user_id'], "&");
            $slicedString = substr($request['user_id'], $position + strlen('&'));
            // echo $slicedString;
            $request['PaymentID'] = $slicedString;
            $request['PaymentID'] = str_replace("PaymentID=", "",  $request['PaymentID']);

            $request['user_id'] = strstr( $request['user_id'], '&PaymentID', true);

        // -----------------------------------------------------------------------------

         $user = appUsers::find($request->user_id);
         if(!$user){
            if (app()->getLocale() == 'ar') {
                  return $this->returnData('status',false, 'هذا العميل غير موجود');
              } else {
                return $this->returnData('status',false, 'User Not Found');
              }
      }
        if($request->doing == 'package') {                              // package
                 $package = Packages::find($request->package_id);
                 
                //  ----------------------------------------------------------------------------------------------------------------------------
                
                if($package->type == 2){                                // star
                        
                        $advertisment = Advertisments::find($request->adv_id);
                        if($advertisment){
                             
                              $last = packages_subscription::create([
                                    'user_id' => $request->user_id,
                                    'package_id' => $request->package_id,
                                    'type' =>  $package->type,
                                    'adv_id' => $request->adv_id,
                                ]);
                                
                                                
                            $days = $package->period;
                            $end_date_of_star = Carbon::now()->addDays($days)->format('Y-m-d');  
                                  $advertisment->update([
                                      'star' => 1,
                                      'end_star'=>$end_date_of_star
                                 ]);
                                 
                             $last->update([
                                  'status' => 1
                                 ]);
                                
                                $name_ar = 'تمييز اعلان';
                                $name_en = 'Ad recognition';

                                 bills::create([
                                    'user_id'=> $request->user_id,
                                    'price'=> $package->price  ,
                                    'product'=> $last->type == 2 ? $advertisment->name : NULL  ,
                                    'product_id'=> $advertisment->id,
                                    'name_ar'=> $name_ar,
                                    'name_en'=> $name_en,
                                    'package'=> $package->name,
                                    'payment_method'=> 'Online payment',
                                ]);
                                
                                payments::create([
                                    'PaymentID'=> $request->PaymentID,
                                    'TranID'=> $request->TranID  ,
                                    'TrackID'=> $request->TrackID  ,
                                    'OrderID'=> $request->OrderID ,
                                    'price'=> $package->price,
                                    'user_id'=> $request->user_id,
                                    'package_id'=> $package->id,
                                    'adv_id'=> $request->adv_id,
                                    'status'=> 1,
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
                                  
                                  
                     
                              //  return $this->returnData('msg',$msg);
                                 
                        }
                        
                }else{      // --------------- adv num or auction num -------------------------------------------------------------------------------------------------------
                    
                              $last = packages_subscription::create([
                                    'user_id' => $request->user_id,
                                    'package_id' => $request->package_id,
                                    'type' =>  $package->type,
                                ]);
                    
                                 if($package->type == 0){
                                    $name_ar = 'باقة اعلانات';
                                    $name_en = 'Ad package';

                                      $user->update([
                                         'adv_number' => $user->adv_number + $package->adv_num
                                     ]);
                                 }elseif($package->type == 1){
                                     
                                    $name_ar = 'باقة مزادات';
                                    $name_en = 'Auction package';
                                    
                                      $user->update([
                                             'auctions_number' => $user->auctions_number + $package->adv_num
                                     ]);
                                 }
                                 
                              $last->update([
                                  'status' => 1
                                 ]);
                             

                                 bills::create([
                                    'user_id'=> $request->user_id,
                                    'price'=> $package->price  ,
                                    'name_ar'=> $name_ar,
                                    'name_en'=> $name_en,
                                    'package'=> $package->name,
                                    'payment_method'=> 'Online payment',
                                ]);
                                
                                payments::create([
                                    'PaymentID'=> $request->PaymentID,
                                    'TranID'=> $request->TranID  ,
                                    'TrackID'=> $request->TrackID  ,
                                    'OrderID'=> $request->OrderID ,
                                    'price'=> $package->price,
                                    'user_id'=> $request->user_id,
                                    'package_id'=> $package->id,
                                    'status'=> 1,
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
                                  
                                  
                     
                              //  return $this->returnData('msg',$msg);
                             
                
                }
                 
        }elseif($request->doing == 'auction_insurance'){                        //-----Auction insurance
                
                        $auction = Auctions::find($request->auction_id);
                    
                        if($auction){
                                
                        depoist_payment_users::create([
                                'user_id'=> $request->user_id,
                                'auction_id'=> $request->auction_id,
                                'amount'=> $auction->deposit_amount,
                         ]);
                       
                         
                          bills::create([
                                'user_id'=> $request->user_id,
                                'price'=> $auction->deposit_amount  ,
                                'product'=> $auction->name  ,
                                'product_id'=> $auction->id  ,
                                'name_ar'=> 'تامين مزاد',
                                'name_en'=> 'Auction insurance',
                                'payment_method'=> 'Online payment',
                            ]);
                            
                            
                               payments::create([
                                    'PaymentID'=> $request->PaymentID,
                                    'TranID'=> $request->TranID  ,
                                    'TrackID'=> $request->TrackID  ,
                                    'OrderID'=> $request->OrderID ,
                                    'price'=> $auction->deposit_amount,
                                    'user_id'=> $request->user_id,
                                    'auction_id'=> $auction->id,
                                    'status'=> 1,
                                ]);
                                
                                
                            
                                //    $check =   Monthly_withdrawals::where('month', 'like', '%' . Carbon::now()->format('Y-m') . '%' )->count();
                                                          
                                //   if($check > 0){
                                //         if (app()->getLocale() == 'ar') {
                                //                 $msg = 'تهانينا لك دخلت السحب الشهرى';
                                //         }else{
                                //                 $msg = 'Congratulations, you entered the monthly draw';
                                //         }
                                        
                                //          return $this->returnData('type',1, $msg);
                                //   }
              
                                //   if (app()->getLocale() == 'ar') {
                                //          return $this->returnData('type',2, 'تم دفع تامين المزاد بنجاح');
                                //     } else {
                                //         return $this->returnData('type',2, 'Auction deposit paid successfully');
                                //     }
                                       
                                       
                                          
                        }                          
                            
                                // if (app()->getLocale() == 'ar') {
                                //     return $this->returnData('status',false, 'هذا المزاد غير موجود');
                                // } else {
                                //   return $this->returnData('status',false, 'Auction Not Found');
                                // }
                                
        }elseif($request->doing == 'pay_one_dinar'){

        $auction = Auctions::find($request->auction_id);
                if( $auction){

                            bills::create([
                                'user_id'=> $request->user_id,
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
                            }else{
                                 if (app()->getLocale() == 'ar') {
                                        $msg = 'تم الدفع بنجاح';
                                } else {
                                       $msg = 'Payment completed successfully';
                                  }
                            }
                            
                               
                   
                            //  return $this->returnData('msg',$msg);
                }
                
                if (app()->getLocale() == 'ar') {
                    return $this->returnData('status',false, 'هذا المزاد غير موجود');
                } else {
                  return $this->returnData('status',false, 'Auction Not Found');
                }
          
        }
    }

    public function payment_error(Request $request){
        
        $request['user_id'] = str_replace("?", "&", $request->user_id);

        $position = strpos( $request['user_id'], "&");
        $slicedString = substr($request['user_id'], $position + strlen('&'));
        // echo $slicedString;
        $request['PaymentID'] = $slicedString;
        $request['PaymentID'] = str_replace("PaymentID=", "",  $request['PaymentID']);

        $request['user_id'] = strstr( $request['user_id'], '&PaymentID', true);
        return   $request;
    }  

}













