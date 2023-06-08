<?php

namespace App\Http\Controllers\Dashboard;

use App\Banks;
use App\CommercialAdv;
use App\Models\Catgories;
use App\Payment_place;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentPlacesController extends Controller
{
    use imageTrait;
    public function index(){
        $allCatgories=Payment_place::latest()->paginate(10);
        return view('dashboard.paymentPlaces.index',compact('allCatgories'));
    }

    public function create(){

        return view('dashboard.paymentPlaces.add');
    }

    public function edit($id){
        $catgoiry=Payment_place::find($id);
        return view('dashboard.paymentPlaces.update',compact('catgoiry'));
    }

    public function store(Request $request){
       $request->validate([
           'name'             =>   'required',
           'lat'              =>   'required',
           'long'              =>   'required',
           'address_address'              =>   'required',
       ]);
       $data=$request->except('img','address_address');
       $data['address']=$request->address_address;
        Payment_place::create($data);
       return redirect()->route('dashboard.paymentPlaces.index')->with('success',__('site.added successfully'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'             =>   'required',
            'lat'              =>   'required',
            'long'              =>   'required',
            'address_address'              =>   'required',
        ]);
        $data=$request->except('img','address_address');
        $data['address']=$request->address_address;
        $pay=Payment_place::find($id);
        $pay->update($data);
        return redirect()->route('dashboard.paymentPlaces.index')->with('success',__('site.added successfully'));
    }

    public function destroy($id){
        Payment_place::destroy($id);
        return redirect()->back()->with('success',__('site.deleted successfully'));
    }

}

