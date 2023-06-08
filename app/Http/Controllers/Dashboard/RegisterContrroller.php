<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterContrroller extends Controller
{
    public function getlogin(){
        return view('auth.login');
    }

   


    public function getregister(){

    }

    public function create(Request $request){

    }

    public function login(Request $request){

        $credentioal = $request->only(['email', 'password']);
        $check = \Illuminate\Support\Facades\Auth::guard('admin')->attempt($credentioal);
        if ($check){
            return redirect()->route('dashboard.statistic');
        }else{
            return redirect()->route('dashboard.getlogin');
        }


    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard.getlogin');

    }
}
