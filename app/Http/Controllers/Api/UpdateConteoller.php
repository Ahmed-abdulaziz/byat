<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\userProfileResource;
use App\Models\appUsers;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateConteoller extends Controller
{
    use imageTrait;
    use GeneralTrait;
    public function updatall(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];
        $valdtior = Validator::make($request->all(), $rules);
        if ($valdtior->fails()) {
            $code = $this->returnCodeAccordingToInput($valdtior);
            return $this->returnValidationError($code, $valdtior);
        } else {
            if (isset($request->user_id) && isset($request->name)) {
                $updatename = DB::table('app_users')->where('id', $request->user_id)->update(['name' => $request->name]);
                if ($updatename) {

                    $user = appUsers::find($request->user_id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('user', $rescus);

                } else {
                    $user = appUsers::find($request->user_id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('user', $rescus);

                }
            } elseif (isset($request->user_id) && isset($request->email)) {

                    $updatename = DB::table('app_users')->where('id', $request->user_id)->update(['email' => $request->email]);
                    if ($updatename) {

                        $user = appUsers::find($request->user_id);
                        $rescus = new userProfileResource($user);
                        return $this->returnData('user', $rescus);

                    } else {
                        $user = appUsers::find($request->user_id);
                        $rescus = new userProfileResource($user);
                        return $this->returnData('user', $rescus);

                    }




            }elseif (isset($request->user_id) && isset($request->phone)){
                $updatename = DB::table('app_users')->where('id', $request->user_id)->update(['phone' => $request->phone]);
                if ($updatename) {

                    $user = appUsers::find($request->user_id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('user', $rescus);

                } else {
                    $user = appUsers::find($request->user_id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('user', $rescus);

                }

            }elseif (isset($request->user_id) && isset($request->user_type)){
                $updatename = DB::table('app_users')->where('id', $request->user_id)->update(['type' => $request->user_type]);
                if ($updatename) {

                    $user = appUsers::find($request->user_id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('user', $rescus);

                } else {
                    $user = appUsers::find($request->user_id);
                    $rescus = new userProfileResource($user);
                    return $this->returnData('user', $rescus);

                }

            }elseif (isset($request->user_id) && isset($request->oldpassword) && isset($request->newpassword)){
                $password=appUsers::find($request->user_id);
                if (Hash::check($request->oldpassword,$password->password)){
                    DB::table('app_users')->where('id','=',$request->user_id)->update(['password'=>bcrypt($request->newpassword)]);
                }else{
                   if (app()->getLocale()=='ar'){
                       return $this->returnError('','خطأ بكلمة المرور القديمه');
                   }else{
                       return $this->returnError('','Error Old Password');
                   }

                }
                $user = appUsers::find($request->user_id);
                $rescus = new userProfileResource($user);
                return $this->returnData('user', $rescus);
            }

            if ($request->has('img')){
                $image=$this->storeImages($request->img,'uploads/user_images');
                $update=appUsers::where('id','=',$request->user_id)->update([
                    'img'     =>    $image
                ]);
                $user = appUsers::find($request->user_id);
                $rescus = new userProfileResource($user);
                return $this->returnData('user', $rescus);
            }
        }



    }
}
