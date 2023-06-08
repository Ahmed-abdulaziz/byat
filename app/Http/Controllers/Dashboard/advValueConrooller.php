<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\appSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class advValueConrooller extends Controller
{

    public function index()
    {
        $notificationText=appSettings::select('id','adv_value')->get();;
        return view('dashboard.advvalue.index',compact('notificationText'));
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
        $about=DB::table('app_settings')->select('adv_value')->where('id',$appSettings)->first();
        // return response()->json($about);
        return view('dashboard.advvalue.edit',compact('appSettings','about'));
    }


    public function update(Request $request,$appSettings)
    {
       $request->validate([
           'adv_value'=>'required'

       ]);

        $data=$request->except('_token');
        $aa=DB::table('app_settings')->where('id',$appSettings)->update(['adv_value'=>$request->adv_value]);
        if ($aa){

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.advvalue.index');
        }
    }

    public function destroy(appSettings $appSettings)
    {

    }
}
