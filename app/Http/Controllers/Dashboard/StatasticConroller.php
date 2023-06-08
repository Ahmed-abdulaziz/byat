<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatasticConroller extends Controller
{
    public function show($type){
        if ($type==1){
            $Bankacounts=DB::table('app_users')->whereDate('created_at','=',Carbon::today())->get();
            return view('dashboard.statsics.newuser',compact('Bankacounts'));

        }else if($type==2) {
            $Bankacounts=DB::table('advertisments')->whereDate('created_at','=',Carbon::today())->get();
            return view('dashboard.statsics.newadv',compact('Bankacounts'));
        }else if($type==3) {
            $payments=DB::table('user__payments')->whereDate('created_at','=',Carbon::today())->get();;
            $paymenttotal=DB::table('user__payments')->whereDate('created_at','=',Carbon::today())->sum('total');;
            return view('dashboard.statsics.index',compact('payments','paymenttotal'));
        }else{
            $payments=DB::table('user__payments')->where('type',2)->whereDate('created_at','=',Carbon::today())->get();
            $paymenttotal=DB::table('user__payments')->where('type',2)->whereDate('created_at','=',Carbon::today())->sum('total');
            return view('dashboard.statsics.index2',compact('payments','paymenttotal'));
        }
    }
}
