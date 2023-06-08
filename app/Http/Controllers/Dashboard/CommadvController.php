<?php

namespace App\Http\Controllers\Dashboard;

use App\CommercialAdv;
use App\Models\Catgories;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommadvController extends Controller
{
    use imageTrait;
    public function index(){
        $allCatgories=CommercialAdv::latest()->paginate(10);
        return view('dashboard.commeAdv.index',compact('allCatgories'));
    }

    public function create(){
        $categories=Catgories::all()->where('parent_id',null);
        return view('dashboard.commeAdv.add',compact('categories'));
    }

    public function edit($id){
        $catgoiry=CommercialAdv::find($id);
        $categories=Catgories::all()->where('parent_id',null);
        return view('dashboard.commeAdv.update',compact('catgoiry','categories'));
    }

    public function store(Request $request){
       $request->validate([
           'cat_id'             =>   'required|numeric',
           'phone'              =>   'required',
           'whatsapp'              =>   'required',
           'img'              =>   'required',
           'lat'              =>   'required',
           'long'              =>   'required',
           'address_address'              =>   'required',
       ]);
       $data=$request->except('img','address_address','_token');
       $image=$this->storeImages($request->img,'uploads/adverisments/');
       $data['address']=$request->address_address;
       $data['img']=$image;
       CommercialAdv::create($data);
       return redirect()->route('dashboard.commeAdv.index')->with('success',__('site.added successfully'));
    }


    public function update(Request $request,$id){
        $request->validate([
            'cat_id'             =>   'required|numeric',
            'phone'              =>   'required',
            'whatsapp'              =>   'required',
            'lat'              =>   'required',
            'long'              =>   'required',
        ]);
        $data=$request->except('img','address_address','_token');
        if ($request->has('img')){
            $image=$this->storeImages($request->img,'uploads/adverisments/');
            $data['address']=$request->address_address;
            $data['img']=$image;
        }
        $adv=CommercialAdv::find($id);
        $adv->update($data);
        return redirect()->route('dashboard.commeAdv.index')->with('success',__('site.added successfully'));
    }


    public function destroy($id){
             $commadv=CommercialAdv::find($id);
             $commadv->delete();
             return redirect()->route('dashboard.commeAdv.index')->with('success',__('site.added successfully'));
    }

}

