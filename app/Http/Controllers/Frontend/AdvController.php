<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Resources\cityandareaResource;
use App\Http\Resources\Frontend\DynamicDataResource;
use App\Http\Resources\Frontend\headerFooterResource;
use App\Http\Resources\usingPlicyCotoller;
use App\Models\Advertisments;
use App\Models\Advimages;
use App\Models\Catgories;
use App\Models\city;
use App\Models\Favoritesadv;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdvController extends Controller
{
   use imageTrait;
    public function index($id)
    {
        $xyz= new headerFooterResource(1);
        $xyzx=collect($xyz);
        $Setting=DB::table('app_settings')->first();
        $i=new usingPlicyCotoller($Setting);
        $info=collect($i);
        $cities=city::all();
        $city=collect(cityandareaResource::collection($cities));
        if ($id==1){
            $Catgories=Catgories::find($id);
            $dynamidataResource=new DynamicDataResource($Catgories);
            $dynamic=collect($dynamidataResource);
            return view('frontend.addcarindex',compact('xyzx','info','Setting','city','dynamic'));
        }elseif($id==2){
            $Catgories=Catgories::find($id);
            $dynamidataResource=new DynamicDataResource($Catgories);
            $dynamic=collect($dynamidataResource);
            return view('frontend.addrealstate',compact('xyzx','info','Setting','city','dynamic'));
        }else{
            $Catgories=Catgories::find($id);
            $dynamidataResource=new DynamicDataResource($Catgories);
            $dynamic=collect($dynamidataResource);
            return view('frontend.addotheradv',compact('xyzx','info','Setting','city','dynamic'));

        }
        }


    public function create()
    {

    }


    public function store(Request $request)
    {
        if($request->type==1){
            $rules = [
                'title' => 'required',
                'phone' => 'required|numeric',
                'about' => 'required',
                //      'img' => 'required',
                'cat_id' => 'required|numeric',
                'sub_id' => 'required|numeric',
                //      'sub_id' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'address' => 'required',
                'price' => 'required|numeric',
                'advertismet_type' => 'required',
                'brand_id' => 'required|numeric',
                'model_id' => 'required|numeric',
                'year' => 'required',
                'status_id' => 'required|numeric',
                'color_id' => 'required|numeric',
                'shape_id' => 'required|numeric',
                'door_number' => 'required|numeric',
                'seat_number' => 'required|numeric',
                'cartransmissions_id' => 'required|numeric',
                'fueltype_id' => 'required|numeric',
                'carenginetype_id' => 'required|numeric',
                'whealsystemtype' => 'required|numeric',
                'city_id' => 'required|numeric',
                'area_id' => 'required|numeric',
            ];
            $owner_type=DB::table('app_users')->where('id','=',$request->user_id)->value('type');
            if ($owner_type==0){
                $own=1;
            }else{
                $own=2;
            }
            $request->validate($rules);
            $data=$request->except('img','_token');
            $data['owner_type'] = $own;
            $adv=Advertisments::create($data);
            if ($adv) {
                if (isset($request->img)) {
                    foreach ($request->file('img') as $iamge) {
                        $imagname = $this->storeImages($iamge, 'uploads/adverisments/');
                        Advimages::create([
                            'img' => $imagname,
                            'adv_id' => $adv->id,
                        ]);
                        $adv->update(['has_image' => 1]);
                    }
                } else {
                    $adv->update(['has_image' => -1,]);
                }
                DB::table('app_users')->where('id', '=', $request->user_id)->decrement('adv_number');
            }
            session()->flash('success','تم بنجاح');
            return redirect()->back();

        }elseif($request->type==2){
            $rules = [
                'title' => 'required',
                'phone' => 'required',
                'about' => 'required',
                //    'img' => 'required',
                'cat_id' => 'required|numeric',
                'sub_id' => 'required|numeric',
                //  'sub_id' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'address' => 'required',
                'price' => 'required|numeric',
                'advertismet_type' => 'required|numeric',
                'city_id' => 'required|numeric',
                'area_id' => 'required|numeric',
                'realstattype_id' => 'required|numeric',
                'realstatepurpose' => 'required|numeric',
                'roomnumber' => 'required|numeric',
                'tolietnumber' => 'required|numeric',
                'placearea' => 'required|numeric',
            ];
            $owner_type=DB::table('app_users')->where('id','=',$request->user_id)->value('type');
            if ($owner_type==0){
                $own=1;
            }else{
                $own=2;
            }
            $data=$request->except('img','_token');
            $data['owner_type'] = $own;
            $adv = Advertisments::create($data);

            if ($adv) {
                if (isset($request->img)){
                    foreach ($request->file('img') as $iamge) {
                        $imagname = $this->storeImages($iamge, 'uploads/adverisments/');
                        Advimages::create([
                            'img' => $imagname,
                            'adv_id' => $adv->id,
                        ]);
                    }
                    $adv->update(['has_image'=>1]);
                }else{
                    $adv->update(['has_image'=>-1,]);
                }

                DB::table('app_users')->where('id','=',$request->user_id)->decrement('adv_number');
            }
            session()->flash('success','تم بنجاح');
            return redirect()->back();

        }else{
            $rules = [
                'title' => 'required',
                'phone' => 'required|numeric',
                'about' => 'required',
                //   'img' => 'required',
                'cat_id' => 'required|numeric',
                'sub_id' => 'required|numeric',
                //  'sub_id' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'address' => 'required',
                'price' => 'required|numeric',
                'advertismet_type' => 'required|numeric',
                'city_id' => 'required|numeric',
                'area_id' => 'required|numeric',

            ];

            $owner_type=DB::table('app_users')->where('id','=',$request->user_id)->value('type');
            if ($owner_type==0){
                $own=1;
            }else{
                $own=2;
            }
            $data=$request->except('img','_token');
            $data['owner_type'] = $own;
            $adv = Advertisments::create($data);

            if ($adv) {
                if (isset($request->img)){
                    foreach ($request->file('img') as $iamge) {
                        $imagname = $this->storeImages($iamge, 'uploads/adverisments/');
                        Advimages::create([
                            'img' => $imagname,
                            'adv_id' => $adv->id,
                        ]);
                    }
                    $adv->update(['has_image'=>1]);
                }else{
                    $adv->update(['has_image'=>-1,]);
                }

                DB::table('app_users')->where('id','=',$request->user_id)->decrement('adv_number');
            }
            session()->flash('success','تم بنجاح');
            return redirect()->back();
        }
    }


    public function show(Advertisments $advertisments)
    {
        //
    }


    public function edit(Advertisments $advertisments)
    {
        //
    }


    public function update(Request $request, Advertisments $advertisments)
    {
        //
    }

    public function destroy(Advertisments $advertisments)
    {

    }

    public function addRemoveFav($id){
        $user_id=Auth::guard('customer')->user()->id;
        $status=DB::table('favoritesadvs')->where('user_id','=',$user_id)->where('adv_id','=',$id)->value('status');
        if ($status==0){
            $parma = ['user_id' => $user_id, 'adv_id' =>$id];
            $query = Favoritesadv::updateOrCreate($parma, ['status' =>1]);
        }else{
            $parma = ['user_id' => $user_id, 'adv_id' => $id];
            $query = Favoritesadv::updateOrCreate($parma, ['status' => 0]);
        }
        return redirect()->back();
    }

}
