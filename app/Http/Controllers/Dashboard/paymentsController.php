<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Advertisments;
use App\Models\appUsers;
use App\Models\Packages;
use App\Models\UserPaymnet;
use App\Traits\notifcationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class paymentsController extends Controller
{
   use notifcationTrait;
    public function index(Request $request)
    {
        $paymnets = UserPaymnet::when($request->search, function ($query) use ($request) {

            return $query->where('user_id', 'like', '%' . $request->search . '%');

        })->where('status','=',0)->latest()->paginate(5);

        return view('dashboard.payments.index', compact('paymnets'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(UserPaymnet $userPaymnet)
    {
        //
    }


    public function edit($id)
    {
        $single=UserPaymnet::find($id);

        if ($single->type==1){
            $catgory=Packages::where('type',1)->get();
            $single->update(['status'=>1]);
            return view('dashboard.payments.update',compact('single','catgory'));

        }else if ($single->type==0){
            $catgory=Packages::where('type',0)->get();
            $single->update(['status'=>2]);
            return view('dashboard.payments.update2',compact('single','catgory','id'));
        }

    }


    public function update(Request $request,$userPaymnet)
    {
        $userpaym=UserPaymnet::find($userPaymnet);
        if ($userpaym->type==1){
            $package=Packages::find($userpaym->package_id);
            $dayDate=date('Y-m-d', time());
            $newData=date('Y-m-d', strtotime($dayDate. ' + 30 day'));
            $adv=Advertisments::where('id',$userpaym->adv_id)->update(['special'=>1,'enddate'=>$newData]);
            if ($adv){
                $userpaym->update(['status'=>1]);
                $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$userpaym->user_id)->value('token');

                $this->pushNotification([
                    'order_id' => null,
                    'title'=> 'SouqReem' ,
                    'body'=> 'تم الاشتراك في الباقه بنجاح',
                    'click_action'=> "ACTION_NORMAL" ,
                    'device_token' => [$fcmtoken],
                    'id'=> null
                ]);
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->route('dashboard.payments.index');

            }else{
                session()->flash('error', __('site.updated_successfully'));
                return redirect()->route('dashboard.payments.index');
            }

        }else{
            $package=Packages::find($userpaym->package_id);
            $appuser=appUsers::where('id',$userpaym->user_id)->update(['adv_number'=>$package->adv_num]);
            if ($appuser){
                $userpaym->update(['status'=>1]);
                $fcmtoken=DB::table('fcmtokens')->where('user_id','=',$userpaym->user_id)->value('token');

                $this->pushNotification([
                    'order_id' => null,
                    'title'=> 'SouqReem' ,
                    'body'=> 'تم الاشتراك في الباقه بنجاح',
                    'click_action'=> "ACTION_NORMAL" ,
                    'device_token' => [$fcmtoken],
                    'id'=> null
                ]);
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->route('dashboard.payments.index');

            }else{
                session()->flash('error', __('site.updated_successfully'));
                return redirect()->route('dashboard.payments.index');
            }

        }
    }


    public function destroy($userPaymnet)
    {
        UserPaymnet::where('id',$userPaymnet)->delete();
        session()->flash('error', __('site.updated_successfully'));
        return redirect()->route('dashboard.payments.index');
    }
}
