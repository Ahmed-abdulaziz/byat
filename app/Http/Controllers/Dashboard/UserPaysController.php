<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appUsers;
use App\Models\User_Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPaysController extends Controller
{
    public function index(Request $request){
        $allusers=appUsers::all();
        $payments=User_Payment::when($request->user_name,function ($q) use($request){
            return $q->where('user_name','like','%'.$request->user_name.'%');
        })->when($request->start_date,function ($q) use($request){
            return $q->where('created_at','>=',$request->start_date);
        })->when($request->end_date,function ($q) use($request){
            return $q->where('created_at','<=',$request->end_date);
        })->latest()->paginate(10);
        $paymenttotal=User_Payment::when($request->user_name,function ($q) use($request){
            return $q->where('user_name','like','%'.$request->user_name.'%');
        })->sum('total');
        return view('dashboard.userpays.index',compact('allusers','payments','paymenttotal'));
    }
}
