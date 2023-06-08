<?php

namespace App\Http\Controllers\Frontend;

use App\Models\appUsers;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use imageTrait;
    public function index(){
        return view('frontend.auth.signup');
    }

    public function newuser(Request $request){
        $request->validate([
            'name' =>  'required',
            'email' =>  'required|email|unique:app_users,email',
            'phone' =>  'required|numeric|min:11|unique:app_users,phone',
            'password' =>  'required|min:6',
            'type' =>  'required|numeric',
            'img' =>  'required',
        ]);
        $data=$request->except('_token','img','vehicle2','password');
        $data['password']=bcrypt($request->password);
        if ($request->has('img')){
            $img=$this->storeImages($request->img,'uploads/user_images/');
            $data['img']=$img;
        }
        $user=appUsers::create($data);
        session()->flash('success','تم التسجيل بنجاح');
        return redirect()->route('login');
    }
}
