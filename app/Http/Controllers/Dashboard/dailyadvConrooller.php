<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class dailyadvConrooller extends Controller
{

    public function index()
    {
        $notificationText=appSettings::select('id','free_adv')->get();;
        return view('dashboard.dailuadvcount.index',compact('notificationText'));
    }

    public function deposit_amount()
    {
        $notificationText=appSettings::select('id','deposit_amount')->get();;
        return view('dashboard.DepoistAmount.index',compact('notificationText'));
    }
    
     public function deposit_amount_edit($id)
    {
     
        
          $about=DB::table('app_settings')->select('deposit_amount')->where('id',$id)->first();
        // return response()->json($about);
        return view('dashboard.DepoistAmount.edit',compact('id','about'));
        
    }
    
     public function deposit_amount_update(Request $request,$appSettings)
    {
       $request->validate([
           'deposit_amount'=>'required'
       ]);

        $data=$request->except('_token');
        $appSettingss=DB::table('app_settings')->select('deposit_amount')->where('id',$appSettings)->update(['deposit_amount'=>$request->deposit_amount]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.deposit_amount');
    } 
    
    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show(appSettings $appSettings)
    {

    }


    public function edit($appSettings)
    {
        $about=DB::table('app_settings')->select('free_adv')->where('id',$appSettings)->first();
        // return response()->json($about);
        return view('dashboard.dailuadvcount.edit',compact('appSettings','about'));
    }


    public function update(Request $request,$appSettings)
    {
       $request->validate([
           'free_adv'=>'required'
       ]);

        $data=$request->except('_token');
        $appSettingss=DB::table('app_settings')->select('free_adv')->where('id',$appSettings)->update(['free_adv'=>$request->free_adv]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.dailuadvcount.index');
    }
    
    

    public function destroy(appSettings $appSettings)
    {

    }
}
