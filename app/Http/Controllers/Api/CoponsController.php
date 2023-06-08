<?php

namespace App\Http\Controllers\Api;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Catgories;
use App\Models\appSettings;
use App\Models\appUsers;
use App\copons;
use App\copon_users;
use Carbon\Carbon;
use App\users_wallet;
class CoponsController extends Controller
{
    use GeneralTrait;
    public function index(Request $request){
        
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
            
            
            $rules = [
                      'copon' => 'required',
            ];
            $valdator = Validator::make($request->all(), $rules);
             if ($valdator->fails()) {
                $code = $this->returnCodeAccordingToInput($valdator);
                return $this->returnValidationError($code, $valdator);
            } 

            
            $copon = copons::where('code',$request->copon)->where('end_date','>=',Carbon::now())->first();
            if($copon){
                    $check = copon_users::where('user_id',$id)->where('copon_id',$copon->id)->count();
                    if($check > 0){
                         if(app()->getLocale() == 'ar'){
                             $msg = 'تم استخدام هذا الكوبون من قبل';
                            }else{
                                 $msg = 'This coupon has been used before';
                            }
                            return $this->returnError('',$msg);
                    }else{
                           users_wallet::create([
                                    'user_id'=> $id,
                                    'money'=> $copon->balance ,
                                    'comment'=> 'Copon',
                             ]);
                
                    
                            copon_users::create([
                                    'user_id' => $id,
                                    'copon_id'=> $copon->id,
                                ]);
                            
                               if(app()->getLocale() == 'ar'){
                                 $msg = 'تم إضافة الرصيد لمحفظتك بنجاح';
                                }else{
                                     $msg = 'The balance has been added to your wallet successfully';
                                }
                            
                            return $this->returnData('status',true, $msg);
                    }
            }
            
              if(app()->getLocale() == 'ar'){
                 $msg = 'هذا الكوبون غير صالح';
                }else{
                     $msg = 'Invalid Copon';
                }
                return $this->returnError('',$msg);


    }



}
