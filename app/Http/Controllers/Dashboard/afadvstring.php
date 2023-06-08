<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class afadvstring extends Controller
{

    public function index()
    {
        $notificationText=appSettings::select('id','after_adv_ar','after_adv_en')->get();;
        return view('dashboard.advstring.index',compact('notificationText'));
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
        $about=appSettings::select('id','after_adv_ar','after_adv_en')->first();
        // return response()->json($about);
        return view('dashboard.advstring.edit',compact('appSettings','about'));
    }


    public function update(Request $request,$appSettings)
    {
       $request->validate([
           'after_adv_ar'=>'required',
           'after_adv_en'=>'required',

       ]);

        $data=$request->except('_token');

        $aa=DB::table('app_settings')->where('id',$appSettings)->update(['after_adv_ar'=>$request->after_adv_ar,'after_adv_en'=>$request->after_adv_en]);
        if ($aa){

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.afadvstring.index');
        }
    }

    public function destroy(appSettings $appSettings)
    {

    }
}
