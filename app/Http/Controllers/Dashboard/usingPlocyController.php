<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class usingPlocyController extends Controller
{

    public function index()
    {
         abort_if(!auth()->user()->hasPermission('read_appsetting'), 403);
         
        $aboutapp=appSettings::select('id','usingplicy_ar','usingplicy_en')->get();;
        return view('dashboard.usingplocy.index',compact('aboutapp'));
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
         
        $about=DB::table('app_settings')->select('usingplicy_ar','usingplicy_en')->where('id',$appSettings)->first();
        // return response()->json($about);
        return view('dashboard.usingplocy.edit',compact('appSettings','about'));

    }


    public function update(Request $request, $appSettings)
    {
         abort_if(!auth()->user()->hasPermission('update_appsetting'), 403);
         
        $about=DB::table('app_settings')->where('id',$appSettings)->update(['usingplicy_ar'=>$request->usingplocy_ar,'usingplicy_en'=>$request->usingplocy_en]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.usingplocy.index');
    }


    public function destroy(appSettings $appSettings)
    {
        //
    }
}
