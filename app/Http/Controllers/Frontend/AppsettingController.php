<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Resources\Frontend\headerFooterResource;
use App\Http\Resources\usingPlicyCotoller;
use App\Models\appSettings;
use App\Models\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AppsettingController extends Controller
{
    public function callus(){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        return view('frontend.callus',compact('xyzx','info','Setting'));
    }

    public function aboutapp(){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        return view('frontend.aboutapp',compact('xyzx','info','Setting'));
    }

    public function usingpolicy(){
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        return view('frontend.usingpolicy',compact('xyzx','info','Setting'));
    }
    public function sendmessage(Request $request){
     $request->validate([
         'name'             =>       'required',
         'email'            =>       'required|email',
         'type'             =>       'required',
         'message'          =>       'required',
     ]);

      $data=$request->except('_token');
      Messages::create($data);
      session()->flash('success','شكرا لتواصلك معانا');
      return redirect()->back();

    }
}
