<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class callusContoller extends Controller
{

    public function index()
    {
         abort_if(!auth()->user()->hasPermission('read_appsetting'), 403);
         
         
        $aboutapp=appSettings::select('id','facebook','twwiter','whatsapp','instgram','youtube','email','phone')->get();
        return view('dashboard.callus.index',compact('aboutapp'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(appSettings $appSettings)
    {
        //
    }


    public function edit($appSettings)
    {
        abort_if(!auth()->user()->hasPermission('update_appsetting'), 403);
        
        $about=DB::table('app_settings')->select('id','facebook','twwiter','whatsapp','instgram','youtube','email','phone')->where('id',$appSettings)->first();
        return view('dashboard.callus.edit',compact('appSettings','about'));

    }


    public function update(Request $request,$appSettings)
    {
        abort_if(!auth()->user()->hasPermission('update_appsetting'), 403);
        
       $request->validate([
           'facebook'=>'required',
           'twwiter'=>'required',
           'instgram'=>'required',
       //    'youtube'=>'required',
         //  'whatsapp'=>'required',
           'email'=>'required|email',
           'phone'=>'required',
       ]);

        $about=DB::table('app_settings')->where('id',$appSettings)->update(['facebook'=>$request->facebook,'twwiter'=>$request->twwiter,'instgram'=>$request->instgram,'youtube'=>$request->youtube,'whatsapp'=>$request->whatsapp,'email'=>$request->email,'phone'=>$request->phone]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.callus.index');

    }


    public function destroy(appSettings $appSettings)
    {
        //
    }
}
