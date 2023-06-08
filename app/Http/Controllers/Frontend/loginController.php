<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class loginController extends Controller
{
    public function index(){
        return view('frontend.auth.login');
    }

    public function validatef(Request $request){
        $request->validate([
            'emailorphone'           =>        'required',
            'password'               =>        'required'
        ]);

        if (filter_var($request->emailorphone, FILTER_VALIDATE_EMAIL)) {
           // $credentioal = $request->only();
            $check = \Illuminate\Support\Facades\Auth::guard('customer')->attempt(['email'=>$request->emailorphone, 'password'=>$request->password]);
            if ($check){
                return redirect()->intended('/');
            }else{
                return redirect()->back()->withErrors('خطأ بالبريد الالكتروني او الرقم السري');
            }
        } else {
            //$credentioal = $request->only(['phone'=>$request->emailorphone, 'password'=>$request->password]);
            $check = \Illuminate\Support\Facades\Auth::guard('customer')->attempt(['phone'=>$request->emailorphone, 'password'=>$request->password]);
            if ($check){
                return redirect()->intended('/');
            }else{
                return redirect()->back()->withErrors('error','خطأ بالهاتف او الرقم السري');
            }
        }


    }


    public function sigout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
