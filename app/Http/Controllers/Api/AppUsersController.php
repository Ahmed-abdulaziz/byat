<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\notificationsresourcse;
use App\Http\Resources\SingleAdvuserDataX;
use App\Http\Resources\userProfileResource;
use App\Http\Resources\profileclientResource;
use App\Http\Resources\UserWalletResource;
use App\Http\Resources\BillsResource;
use App\Models\Advertisments;
use App\Models\appUsers;
use App\Models\Banusers;
use App\Models\UserPaymnet;
use App\users_wallet;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\codes;
use App\Balance_recovery;
use App\appuser_requirments;
use App\Notifications;
use App\Auctions;
use App\auction_users;
use App\bills;
class AppUsersController extends Controller
{
    use GeneralTrait;
    use imageTrait;
    public function banusers(Request $request){
        $rules=[
            'user_id'     =>    'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
           $id=$this->getUserID($request->bearerToken());
           if ($id!=null){
               $banuser=Banusers::updateOrCreate([
                   'user_id'        =>      $id,
                   'second_user'    =>      $request->user_id,
                   'status'         =>      1,

               ]);
              if ($banuser){
                  if (app()->getLocale()=='ar'){
                      return $this->returnSuccessMessage('تم حظر المستخدم بنجاح');
                  }else{
                      return $this->returnSuccessMessage('User Baned Successfully');
                  }
              }
           }
        }
    }

    public function updateProfile(Request $request){
       $id=$this->getUserID($request->bearerToken());

       if ($id>0){

            if ($request->has('name')){
               $update=appUsers::where('id','=',$id)->update([
                   'name'     =>    $request->name
               ]);
            }if ($request->has('email')){
                $update=appUsers::where('id','=',$id)->update([
                    'email'     =>    $request->email
                ]);
            }if ($request->has('phone')){
                $update=appUsers::where('id','=',$id)->update([
                    'phone'     =>    $request->phone
                ]);
            }if ($request->has('user_type')){
               $update=appUsers::where('id','=',$id)->update([
                   'type'     =>    $request->user_type
               ]);
           }
           if ($request->has('img')){
               $image=$this->storeImages($request->img,'uploads/user_images');
               $update=appUsers::where('id','=',$id)->update([
                   'img'     =>    $image
               ]);
           }
            if ($request->has('oldpassword')){
                $old=appUsers::find($id);
                if (Hash::check($request->oldpassword,$old->password)){
                    $update=appUsers::where('id','=',$id)->update([
                        'password'     =>    bcrypt($request->newpassword),
                    ]);
                }else{
                    if (app()->getLocale()=='ar'){
                        return $this->returnError('','كلمة المرور القديمه خاطئه');
                    }else{
                        return $this->returnError('','Wrong Old Password');
                    }
                }
            }
           return $this->returnData('data',new userProfileResource(appUsers::find($id)));
       }
    }


   public function myadv(Request $request){

      $id=$this->getUserID($request->bearerToken());
      $myadv=Advertisments::all()->where('user_id','=',$id);
      $adv=alladvertismetsResource::collection($myadv);
      return $this->returnData('data',$adv);
   }

    public function myfav(Request $request){
        $id=$this->getUserID($request->bearerToken());
        $user=appUsers::find($id);
        $myadv=$user->favadv;
        foreach ($myadv as $key=>$single){
            $myadv[$key]->check_id=$id;
        }
        $adv=alladvertismetsResource::collection($myadv);
        return $this->returnData('data',$adv);
    }

    public function payment(Request $request){

        $rules=[
            'payment_method'     =>    'required',
            'type'               =>    'required',
            'package_id'         =>    'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
            $user_id=$this->getUserID($request->bearerToken());
            if ($request->payment_method==3 && $request->type==1){

                $rules=[
                    'adv_id'     =>    'required',
                    'img'        =>    'required',
                ];
                $validator=Validator::make($request->all(),$rules);
                if ($validator->fails()){
                    $code=$this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code,$validator);
                }else{
                  $iamge=$this->storeImages($request->img,'uploads/paymnets/');
                  $adv=UserPaymnet::create([
                      'user_id'       =>         $user_id,
                      'img'       =>         $iamge,
                      'adv_id'       =>         $request->adv_id,
                      'package_id'       =>         $request->package_id,
                      'type'       =>         $request->type,
                      'payment_method'       =>         $request->payment_method,

                  ]);
                  if($adv){
                      return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');
                  }

                }

            }else if ($request->payment_method==2 && $request->type==1){
                $rules=[
                    'adv_id'     =>    'required',
                ];
                $validator=Validator::make($request->all(),$rules);
                if ($validator->fails()){
                    $code=$this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code,$validator);
                }else{
                    $adv=UserPaymnet::create([
                        'user_id'       =>         $user_id,
                        'adv_id'       =>         $request->adv_id,
                        'package_id'       =>         $request->package_id,
                        'type'       =>         $request->type,
                        'payment_method'       =>         $request->payment_method,

                    ]);
                    if($adv){
                        return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');
                    }

                }

            }else if ($request->payment_method==1 && $request->type==1){
                $rules=[
                    'adv_id'     =>    'required',

                ];
                $validator=Validator::make($request->all(),$rules);
                if ($validator->fails()){
                    $code=$this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code,$validator);
                }else{
                    $adv=UserPaymnet::create([
                        'user_id'       =>         $user_id,

                        'adv_id'       =>         $request->adv_id,
                        'package_id'       =>         $request->package_id,
                        'type'       =>         $request->type,
                        'payment_method'       =>         $request->payment_method,

                    ]);
                    if($adv){
                        return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');
                    }

                }
            }else if($request->payment_method==3 && $request->type==0){
                $iamge=$this->storeImages($request->img,'uploads/paymnets/');
                $adv=UserPaymnet::create([
                    'user_id'       =>         $user_id,
                    'package_id'       =>         $request->package_id,
                    'type'       =>         $request->type,
                    'img'       =>         $iamge,
                    'payment_method'       =>         $request->payment_method,

                ]);
                if($adv){
                    return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');
                }
            }
            else if($request->payment_method==2 && $request->type==0){
                $adv=UserPaymnet::create([
                    'user_id'       =>         $user_id,
                    'package_id'       =>         $request->package_id,
                    'type'       =>         $request->type,
                    'payment_method'       =>         $request->payment_method,

                ]);
                if($adv){
                    return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');
                }
            }
            else if($request->payment_method==1 && $request->type==0){
                $adv=UserPaymnet::create([
                    'user_id'       =>         $user_id,
                    'package_id'       =>         $request->package_id,
                    'type'       =>         $request->type,
                    'payment_method'       =>         $request->payment_method,

                ]);
                if($adv){
                    return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');
                }
            }else{
                return  $this->returnError('','هناك خطأ ما');
            }
        }

    }

    public function userProfile(Request $request){
        $user_id =$this->getUserIDNOt($request->bearerToken());
        $rules=[
            'user_id'     =>    'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
             $user=appUsers::find($request->user_id);
             $user->check_id=$user_id;
             $resource=new userProfileResource($user);
             return $this->returnData('user',$resource);
        }
    }
    
    
      public function wallet_amount_users_wallets(Request $request){
        $rules=[
            'user_id'     =>    'required',
            
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
             $amount=users_wallet::where('user_id',$request->user_id)->sum('money');
             return $this->returnData('amount',$amount);
        }
    }
    
    
      public function charge_wallet(Request $request){
        $rules=[
                'user_id'     =>    'required',
                'code'     =>    'required',
            
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
             $check=codes::where('code',$request->code)->whereNull('user_id')->count();
             if($check > 0){
                 $code=codes::where('code',$request->code)->whereNull('user_id')->first();
                        users_wallet::create([
                                'user_id'=>$request->user_id,
                                'money'=>$code->amount,
                                'comment'=>'شحن رصيد',
                                'code'=>$request->code,
                                'amount'=>$code->amount
                            ]);
                        $code->update([
                                'user_id'=>$request->user_id
                            ]);
                                 if (app()->getLocale()=='ar'){
                                    return $this->returnSuccessMessage('تم شحن المحفظة بنجاح');
                                }else{
                                    return $this->returnSuccessMessage('The wallet has been successfully shipped');
                                }
                        
             }else{
                   return $this->returnData('status',false, 'This Code does not exist');
             }
             return $this->returnData('amount',$amount);
        }
    }
    
    
      public function balance_recovery(Request $request){
        
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
            
            
            $rules = [
                      'type' => 'required',
            ];
            $valdator = Validator::make($request->all(), $rules);
             if ($valdator->fails()) {
                $code = $this->returnCodeAccordingToInput($valdator);
                return $this->returnValidationError($code, $valdator);
            } 
                $amount=users_wallet::where('user_id',$id)->sum('money');
                $check = Balance_recovery::where('user_id',$id)->where('status',0)->count();
                if($check > 0){
                     return  $this->returnError('','مازال طلبكم تحت مراجعة مدير التطبيق');
                }
                if($amount > 0){
                       Balance_recovery::create([
                            'user_id'=>$id,
                            'type'=>$request->type ,
                        ]);
                        
                         return  $this->returnSuccessMessage('تم الارسال بنجاح انتظر المراجعه من مدير التطبيق');

                }else{
                         return  $this->returnError('','لا يوجد لديك رصيد بالمحفظه');
                }
             
                
        
    }
    
    
    public function change_user_name(Request $request){
        $rules=[
            'user_id'     =>    'required',
            'name'     =>    'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
                $user = appUsers::find($request->user_id);
                if($user){
                    
                         if (app()->getLocale()=='ar'){
                        $requirment = "( $user->name ) تغيير الاسم";
                    }else{
                       $requirment = "change name ( $user->name )";
                    }
                    appuser_requirments::create([
                        'user_id'=>$request->user_id,
                        'requirment'=>$requirment,
                        'change'=>$request->name,
                         'type'=>1,
                    ]);
                
                    return  $this->returnSuccessMessage('تم ارسال طلبك للاداره وفى حالة الموافقه سيتم تعديل الاسم');
        
            
                    
                }
           
        }
    }
    
     public function change_email(Request $request){
        $rules=[
            'user_id'     =>    'required',
            'email'     =>    'required|email|unique:app_users,email,'.$request->id,
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
                $user = appUsers::find($request->user_id);
                if($user){
                    
                    $user->update([
                           'email'=>$request->email,
                        ]);
                    return  $this->returnSuccessMessage('تم تغيير البريد الاليكترونى بنجاح');
        
            
                    
                }
           
        }
    }
    
    
    public function my_notifications(Request $request){
        $rules=[
            'user_id'     =>    'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }else{
                $Notifications = Notifications::where("user_id" , $request->user_id)->get();
                
                $data=notificationsresourcse::collection($Notifications);
                return $this->returnData('notifications', $data);
        }
    }
    
    
      
    public function delete_notification(Request $request){
                $rules=[
                    'ids'     =>    'required',
                ];
                $validator=Validator::make($request->all(),$rules);
                if ($validator->fails()){
                    $code=$this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code,$validator);
                }
                
                $Notifications = Notifications::whereIn('id',$request->ids);
                
                if($Notifications->count() > 0){
                    $Notifications->delete();
                }
                return $this->returnData('msg', 'messages is deleted');
        
    }
    
    
     public function user_profile($user_id){
                $user = appUsers::find($user_id);
                if($user){
                    $resource=new profileclientResource($user);
                    return $this->returnData('user', $resource);
                }
               return $this->returnData('status',false, 'User Not Found');
        
    }
    
    
    
    public function deleteuser(Request $request){
      
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
            
             $user = appUsers::find($id);
             if($user){
                $user->delete();
                return $this->returnData('status',true, 'Success');
             }
           
               return $this->returnData('status',false, 'User Not Found');
            
        
    }
    
    
       public function mybills(Request $request){
      
           $token = $request->bearerToken();
            $id = $this->getUserID($token);  
            if(!is_numeric($id)){
                return $id;
            }
            
            $data = bills::where('user_id',$id)->orderBy('id','DESC')->get();
            $data=BillsResource::collection($data);
            return $this->returnData('bills', $data);

        
    }
    
    public function read_notifications($id){
       $notification =  Notifications::find($id);
       if($notification){
           $notification->update(['readed'=> 1]);
       }
        return  $this->returnSuccessMessage('done read');
    }
    
}
