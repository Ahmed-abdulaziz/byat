<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\Frontend\headerFooterResource;
use App\Http\Resources\Frontend\HomeadvsResource;
use App\Http\Resources\usingPlicyCotoller;
use App\Models\Advertisments;
use App\Models\appUsers;
use App\Models\Favoritesadv;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppuserController extends Controller
{
    use imageTrait;
    public function profile(){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        return view('frontend.myprofile',compact('xyzx','Setting','info'));
    }


    public function myads(){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        $userid=\Illuminate\Support\Facades\Auth::guard('customer')->user()->id;
        $myadv=Advertisments::all()->where('user_id','=',$userid);
        $resource=HomeadvsResource::collection($myadv);
        $ads=collect($resource);
        return view('frontend.myads',compact('xyzx','Setting','info','ads'));
    }

    public function myfav(){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        $userid=\Illuminate\Support\Facades\Auth::guard('customer')->user()->id;
        $user=appUsers::find($userid);
        $myadv=$user->favadv;
        $resource=HomeadvsResource::collection($myadv);
        $ads=collect($resource);
        return view('frontend.myfav',compact('xyzx','Setting','info','ads'));
    }
   public function userUpdateProfile(Request $request){
            $request->validate([
                'name'        =>    'required',
                'email'       => ['required', Rule::unique('app_users')->ignore($request->id)],
                'phone'       =>    [ 'required','numeric',Rule::unique('app_users')->ignore($request->id)],
            ]);
           $data=$request->except('_token','img','password','user_id');
            if ($request->has('img')){
              $image=$this->storeImages($request->img,'uploads/user_images/');
                $data['img']=$image;
            }
            if ($request->has('password')){
              $password=bcrypt($request->password);
                $data['password']=$password;
            }

           $user=appUsers::find($request->user_id);
           $user->update($data);
           session()->flash('success','تم تحديث البيانات بنجاح');
           return redirect()->back();
   }

}
