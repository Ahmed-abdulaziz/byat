<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class aboutappController extends Controller
{

    public function index()
    {
        abort_if(!auth()->user()->hasPermission('read_appsetting'), 403);
        
       $aboutapp=appSettings::select('id','aboutapp_ar','aboutapp_en')->get();
       return view('dashboard.aboutapp.index',compact('aboutapp'));
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
         abort_if(!auth()->user()->hasPermission('update_appsetting'), 403);
         
        $about=DB::table('app_settings')->select('aboutapp_ar','aboutapp_en')->where('id',$appSettings)->first();
        // return response()->json($about);
        return view('dashboard.aboutapp.edit',compact('appSettings','about'));

    }


    public function update(Request $request,$appSettings)
    {
         abort_if(!auth()->user()->hasPermission('update_appsetting'), 403);
         
        $about=DB::table('app_settings')->where('id',$appSettings)->update(['aboutapp_ar'=>$request->aboutapp_ar,'aboutapp_en'=>$request->aboutapp_en]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.aboutapp.index');
    }

    public function destroy(appSettings $appSettings)
    {

    }
}
