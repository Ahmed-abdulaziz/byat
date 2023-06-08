<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use App\Models\notfication;
use App\Traits\notifcationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotficationtextController extends Controller
{
use notifcationTrait;
    public function index()
    {
        $notificationText=appSettings::select('id','notifictionTitile_ar','notifictionTitile_en','notifictionBody_ar','notifictionBody_en')->get();;
        return view('dashboard.notificationText.index',compact('notificationText'));
    }


    public function create()
    {
        return view('dashboard.notificationText.sendgenralnotfiaction');

    }


    public function store(Request $request)
    {
        $msg=$request->notfication;
        $this->broadCastNotification('laytwfk App',$msg,'laytwfkApp');
        return redirect()->route('dashboard.notificationText.create')->with(['success'=>'تم ارسال الاشعار']);
    }


    public function show(appSettings $appSettings)
    {
        //
    }


    public function edit($appSettings)
    {
        $notificationText=appSettings::select('id','notifictionTitile_ar','notifictionTitile_en','notifictionBody_ar','notifictionBody_en')->first();;
        return view('dashboard.notificationText.edit',compact('notificationText','appSettings'));
    }

    public function update(Request $request,$appSettings)
    {
     $request->validate([
         'notifictionTitile_ar'=>'required',
         'notifictionTitile_en'=>'required',
         'notifictionBody_ar'=>'required',
         'notifictionBody_en'=>'required',

     ]);

     $data=$request->except('_token');
     $appSettingss=appSettings::find($appSettings);
      $aa=$appSettingss->update($data);
        if ($aa){

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.notificationText.index');
        }
    }

    public function destroy(appSettings $appSettings)
    {
        //
    }
}
