<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\notifcationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\appUsers;
use App\Notifications;
class sendGenralNotfications extends Controller
{
    use notifcationTrait;
    public function index(){
          abort_if(!auth()->user()->hasPermission('Send_Genral_Notifctions'), 403);
          
       return view('dashboard.genralNotfication.add');
    }
    public function sendnotifaction(Request $request){
         abort_if(!auth()->user()->hasPermission('Send_Genral_Notifctions'), 403);
         
         $title=$request->title;
         $this->broadCastNotification($title,$request->notifcatoion,'laytwfkApp');
         $users=appUsers::get();
         foreach($users as $user){
             Notifications::create([
                    'msg'=> $request->notifcatoion,
                    'title'=> $title,
                    'user_id'=> $user->id
                 ]);
         }
         return redirect()->route('dashboard.getnotifview')->with(['success'=>'تم ارسال الاشعار']);
    }
}
