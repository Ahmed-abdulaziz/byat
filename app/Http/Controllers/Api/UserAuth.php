<?php

namespace App\Http\Controllers\Api;

use App\DeviceToken;
use App\Gifts;
use App\GiftSubcriper;
use App\Http\Resources\SingleAdvuserData;
use App\Http\Resources\SingleAdvuserDataX;
use App\Http\Resources\userProfileResource;
use App\Models\appSettings;
use App\Models\appUsers;
use App\Models\Fcmtokens;
use App\Models\phoneCheck;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use http\Header;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Vistoer;
use Carbon\Carbon;
use GuzzleHttp\Client;
class UserAuth extends Controller
{
    use GeneralTrait;
    use imageTrait;

    public function getCode(Request $request)
    {

        $rules = [
            'phone' => 'required|unique:app_users,phone'
        ];
        $valdatior = Validator::make($request->all(), $rules);
        if ($valdatior->fails()) {
            if (app()->getLocale() == 'ar') {
                return $this->returnError('', 'هذا الهاتف مسجل بالفعل');
            } else {
                $code = $this->returnCodeAccordingToInput($valdatior);
                return $this->returnValidationError($code, $valdatior);
            }

        } else {
            $code = random_int(1000, 9999);
            $math = ['phone' => $request->phone];
            $cheack = phoneCheck::updateOrCreate($math, ['code' => $code]);
            
            $phone = $request->phone;
            $start = substr($phone, 0, 3);
            // $end = substr($phone, 3);
            if($start == 965){
                $final_phone = $phone;
            }else{
                $final_phone = '965'.$phone;
            }
            $msg = "تطبيق لايطوفك - كود التحقيق الخاص بك هو  : $code";
            $client = new Client;
            $request = $client->get("https://www.kwtsms.com/API/send/?username=####&password=####&sender=####&mobile=$final_phone&lang=3&message=$msg");
            $response = $request->getBody();
            $res = explode(":", $response);

            return $this->returnData('code', $code, 'success');
        }
    }


    public function checkphone(Request $request)
    {

        $rules = [
            'phone' => 'required|exists:app_users,phone'
        ];
        $valdatior = Validator::make($request->all(), $rules);
        if ($valdatior->fails()) {
            if (app()->getLocale() == 'ar') {
                return $this->returnError('', 'هذا الهاتف غير مسجل');
            } else {
                $code = $this->returnCodeAccordingToInput($valdatior);
                return $this->returnValidationError($code, $valdatior);
            }

        } else {
            $code = random_int(1000, 9999);
            
            $phone = $request->phone;
            $start = substr($phone, 0, 3);
            // $end = substr($phone, 3);
            if($start == 965){
                $final_phone = $phone;
            }else{
                $final_phone = '965'.$phone;
            }
             $msg = "تطبيق لايطوفك - كود التحقيق الخاص بك هو  : $code";
            $client = new Client;
            $request = $client->get("https://www.kwtsms.com/API/send/?username=####&password=####&sender=####&mobile=$final_phone&lang=3&message=$msg");
            $response = $request->getBody();
            $res = explode(":", $response);
            
            return $this->returnData('code',$code,'success');
        }
    }
    
     public function updatephone(Request $request)
    {

        $rules = [
             'user_id' => 'required',
            'phone' => 'required|unique:app_users,phone'
        ];
        $valdatior = Validator::make($request->all(), $rules);
        if ($valdatior->fails()) {
            
                $code = $this->returnCodeAccordingToInput($valdatior);
                return $this->returnValidationError($code, $valdatior);
            

        } else {
            
                 $user = appUsers::find($request->user_id);
                $user->update([
                    'phone'=>$request->phone,
                ]);
            return $this->returnData('msg','Phone Updated','success');
        }
    }
    
      public function updateimage(Request $request)
        {
    
            $rules = [
                 'user_id' => 'required',
                'image' => 'required|file'
            ];
            $valdatior = Validator::make($request->all(), $rules);
            if ($valdatior->fails()) {
                
                    $code = $this->returnCodeAccordingToInput($valdatior);
                    return $this->returnValidationError($code, $valdatior);
                
    
            } else {
                
                    $user = appUsers::find($request->user_id);
                    $imageName = $this->storeImages($request->image, $this->main_path().'uploads/user_images/');
                          Storage::delete($this->main_path().'uploads/user_images/'.$user->img);
                        
                    $user->update([
                        'img'=> $imageName,
                    ]);
                return $this->returnData('msg','Image Updated','success');
            }
        }

    
    public function restpassword(Request $request)
    {
        $rules = [
            'phone' => 'required|exists:app_users,phone',
            'newPassword' => 'required',
        ];
        $valdatior = Validator::make($request->all(), $rules);
        if ($valdatior->fails()) {
            if (app()->getLocale() == 'ar') {
                return $this->returnError('', 'هذا الهاتف غير مسجل');
            } else {
                $code = $this->returnCodeAccordingToInput($valdatior);
                return $this->returnValidationError($code, $valdatior);
            }

        } else {

            DB::table('app_users')->where('phone', '=', $request->phone)->update(['password' => bcrypt($request->newPassword)]);
            if (app()->getLocale() == 'ar') {
                return $this->returnSuccessMessage('تم تحديث كلمة المرور بنجاح');
            } else {
                return $this->returnSuccessMessage('Password updated Successfully');
            }
        }

    }

    public function login_socail(Request $request){
        $rules = [
            'provider_id' => 'required',
        ];
         $valdatior = Validator::make($request->all(), $rules);
         if ($valdatior->fails()) {
                $code = $this->returnCodeAccordingToInput($valdatior);
                return $this->returnValidationError($code, $valdatior);
        }
        
          $User= appUsers::where('provider_id' , $request->provider_id)->first();
          if($User){
                $token =   \Illuminate\Support\Facades\Auth::guard('app_users')->login($User);
                if (!$token) {
                    if (app()->getLocale() == 'ar') {
                        return $this->returnError('', 'هناك خطأ بالبينات');
                    } else {
                        return $this->returnError('', 'Invalid Data');
                    }
                }else{
                    $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                    $customer->api_token = $token;
                    $customer->save();
                    $rescus = new userProfileResource($customer);
                    return $this->returnData('user', $rescus);
                }
          }
       
            if (app()->getLocale() == 'ar') {
                return $this->returnError('', 'هناك خطأ بالبينات');
            } else {
                return $this->returnError('', 'Invalid Data');
            }
          
    }
    public function login(Request $request)
    {
        $rules = [
            'emailorphone' => 'required',
            'password' => 'required',
        ];

        if (filter_var($request->emailorphone, FILTER_VALIDATE_EMAIL)) {
            $token = \Illuminate\Support\Facades\Auth::guard('app_users')->attempt(['email' => $request->emailorphone, 'password' => $request->password ]);
            if (!$token) {
                if (app()->getLocale() == 'ar') {
                    return $this->returnError('', 'هناك خطأ بالبينات');
                } else {
                    return $this->returnError('', 'Phone Number Or Email Error');
                }
            } else {
                $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                if($customer->status != 1){
                      if (app()->getLocale() == 'ar') {
                            return $this->returnError('', 'هذا الحساب موقوف . برجاء مراجعة الادمن');
                        } else {
                           return $this->returnError('', 'This account has been Blocked. Please refer to the admin');
                        }
                }
                $customer->api_token = $token;
                $customer->save();
                $rescus = new userProfileResource($customer);
                
             
                    
                return $this->returnData('user', $rescus);
            }
        } else {
            $token = \Illuminate\Support\Facades\Auth::guard('app_users')->attempt(['phone' => $request->emailorphone, 'password' => $request->password]);
            if (!$token) {
                if (app()->getLocale() == 'ar') {
                    return $this->returnError('', 'هناك خطأ بالبينات');
                } else {
                    return $this->returnError('', 'Phone Number Or Email Error');
                }
            } else {
                $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                  if($customer->status != 1){
                      if (app()->getLocale() == 'ar') {
                            return $this->returnError('', 'هذا الحساب موقوف . برجاء مراجعة الادمن');
                        } else {
                           return $this->returnError('', 'This account has been Blocked. Please refer to the admin');
                        }
                }
                $customer->api_token = $token;
                $customer->save();
                $rescus = new userProfileResource($customer);
                
                 
                   
                return $this->returnData('user', $rescus);
            }
        }

    }


    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'sometimes|unique:app_users,email|email',
            'phone' => 'required|unique:app_users,phone',
            'password' => 'sometimes',
            'device_id' => 'required',
            'provider_id' => 'sometimes|unique:app_users,provider_id',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
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


            $device=DeviceToken::updateOrcreate([
                'device_tokens'        =>$request->device_id
            ],['user_id'=>$appuser->id,'status'=>1]);//update device gift status

            $today=Date('Y-m-d');
            // $gift=Gifts::where('end_date','>',$today)->first();
            // if ($gift){
            //     GiftSubcriper::updateOrcreate([
            //         'user_id'      =>       $appuser->id ,
            //         'gift_id'      =>       $gift->id ,
            //     ]);
                // $appuser->update(['subscrip_number' =>'#45d9f3b'.$device->id]);
            // }
            //subscript to current gift

            // $credentioal = $request->only(['phone', 'password']);
            if(empty($request->provider_id)){
                 $token = \Illuminate\Support\Facades\Auth::guard('app_users')->attempt(['phone' => $request->phone, 'password' => $request->password]);
            }else{
                 $token =   \Illuminate\Support\Facades\Auth::guard('app_users')->login($appuser);
            }
           
            if (!$token) {
                if (app()->getLocale() == 'ar') {
                    return $this->returnError('', 'هناك خطأ بالبينات');
                } else {
                    return $this->returnError('', 'Phone Number Or Email Error');
                }
            } else {
                $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                $customer->api_token = $token;
                $customer->save();
                $rescus = new userProfileResource($customer);
               
                   
                return $this->returnData('user', $rescus);
            }
        }
    }


    public function savefsmtoken(Request $request)
    {
        $rules = [
            'token' => 'required',
            'user_id' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            // $token = $request->bearerToken();
            // $id = $this->getUserID($token);
            
                   
                       
            $user = ['user_id' => $request->user_id];
            $cheack = Fcmtokens::updateOrCreate($user, ['token' => $request->token]);
            return $this->returnSuccessMessage('Saved Successfully');
        }
    }


    public function socail(Request $request)
    {
        $rules = [
            'name' => 'required',
            'provider' => 'required',
            'provider_id' => 'required',
        ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $check = appUsers::where('provider', '=', $request->provider)->where('provider_id', '=', $request->provider_id)->first();
            if ($check) {
                //$credentioal = $request->only(['provider', 'provider_id']);
                $token = JWTAuth::fromUser($check);
                $check->api_token = $token;
                if (isset($request->email)){
                    $rules = [
                        'email' => 'unique:app_users,email',
                    ];
                    $valdator = Validator::make($request->all(), $rules);
                    if ($valdator->fails()) {
                        $check->save();
                        $rescus = new userProfileResource($check);
                        return $this->returnData('data', $rescus);
                    }else{
                        appUsers::where('id','=',$check->id)->update(['email' => $request->email]);
                    }

                }
                $check->save();
                $user=appUsers::find($check->id);
                $rescus = new userProfileResource($user);
                return $this->returnData('data', $rescus);

            } else {
                $advfree = DB::table('app_settings')->where('id', '=', 1)->value('free_adv');
                $free_auctions= DB::table('app_settings')->where('id', '=', 1)->value('free_auctions');
                $appuser = appUsers::create([
                    'name' => $request->name,
                    'provider' => $request->provider,
                    'img' => 'default.png',
                    'provider_id' => $request->provider_id,
                    'adv_number' => $advfree,
                     'auctions_number' => $free_auctions,
                ]);
                if ($appuser) {
                    $token = JWTAuth::fromUser($appuser);
                    if (isset($request->email)) {
                        $rules = [
                            'email' => 'unique:app_users,email',
                        ];
                        $valdator = Validator::make($request->all(), $rules);
                        if ($valdator->fails()) {
                            $appuser->api_token = $token;
                            $appuser->save();
                            $rescus = new userProfileResource($appuser);
                            return $this->returnData('data', $rescus);
                        }else{
                            appUsers::where('id','=',$appuser->id)->update(['email' => $request->email]);
                        }

                    }
                    $appuser->api_token = $token;
                    $appuser->save();
                    $user=appUsers::find($appuser->id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('data', $rescus);

                }
            }

        }

    }


    public function logout(Request $request)
    {
        // Get JWT Token from the request header key "Authorization"
        $token = $request->bearerToken();
        // Invalidate the token
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            $token = $request->bearerToken();
            $id = $this->getUserID($token);
            $user = ['user_id' => $id];
            Fcmtokens::where($user)->delete();
            
            return response()->json([
                "status" => true,
                "message" => "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                "status" => false,
                "message" => "Failed to logout, please try again."
            ], 500);
        }

    }


    public function userProfile(Request $request)
    {
        $rules = [
            'user_id' => 'required',

        ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            
            
           $appuser=appUsers::find($request->user_id);
           $resource=new SingleAdvuserDataX($appuser);
        
                
           return $this->returnData('data',$resource);

        }
    }
    
    
    public function checktoken(Request $request){

        $id=DB::table('app_users')->where('api_token','=',$request->token)->value('id');
        if ($id==null){
             return $this -> returnError('msg','Expired');
        }else{
            return $this->returnSuccessMessage('Not Expired');
        }
    }
    
    
       public function change_password(Request $request){
        $rules = [
            'oldPassword' => 'required',
            'newPassword' => 'required|confirmed',
        ];
        $valdatior = Validator::make($request->all(), $rules);
        if ($valdatior->fails()) {
                $code = $this->returnCodeAccordingToInput($valdatior);
                return $this->returnValidationError($code, $valdatior);

        } else {
                    
                    $token = $request->bearerToken();
                    $id = $this->getUserID($token);  
                    if(!is_numeric($id)){
                         return $id;
                    }
                    $user=appUsers::find($id);
                    if($user){
                           
                         if (Hash::check($request->oldPassword,$user->password)){
                                    
                                    $user->update([
                                        'password'=>bcrypt($request->newPassword)
                                    ]);
                                    
                            }else{
                                
                                if (app()->getLocale() == 'ar') {
                                    return $this->returnError('','كلمة المرور القديمه غير صحيحه');
                                } else {
                                    return $this->returnError('','Old Password Incorrect');
                                } 
                            }
                            
                    
                                if (app()->getLocale() == 'ar') {
                                    return $this->returnSuccessMessage('تم تحديث كلمة المرور بنجاح');
                                } else {
                                    return $this->returnSuccessMessage('Password updated Successfully');
                                }
                    
                        }else{
                             return $this->returnError('','Invalid Token');
                        }
                
                   
        }

    }
}
