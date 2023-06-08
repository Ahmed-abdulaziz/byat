<?php

namespace App\Http\Controllers\Dashboard;

use App\Banks;
use App\CommercialAdv;

use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanksController extends Controller
{
    use imageTrait;
    public function index(){
        $allCatgories=Banks::latest()->paginate(10);
        return view('dashboard.banks.index',compact('allCatgories'));
    }

    public function create(){

        return view('dashboard.banks.add');
    }

    public function edit($id){
        $banks=Banks::find($id);
        return view('dashboard.banks.update',compact('banks'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'             =>   'required',
            'about'            =>   'required',
            'iban'             =>   'required',
            'account_number'   =>   'required',
            'img'              =>   'required',
        ]);
        $bank=Banks::find($id);
        $data=$request->except('img');
        $image=$this->storeImages($request->img,'laytwfk/public/uploads/banks/');
        $data['image']=$image;
        $bank->update($data);
        return redirect()->back()->with('success',__('site.updated successfully'));
    }

    public function store(Request $request){
       $request->validate([
           'name'             =>   'required',
           'about'            =>   'required',
           'iban'             =>   'required',
           'account_number'   =>   'required',
           'img'              =>   'required',
       ]);
       $data=$request->except('img');
       $image=$this->storeImages($request->img,'laytwfk/public/uploads/Banks/');
       $data['image']=$image;
       Banks::create($data);
       return redirect()->back()->with('success',__('site.added successfully'));
    }

    public function destroy($id){
       $bank=Banks::find($id);
       $bank->delete();
       return redirect()->back()->with('success',__('site.deleted successfully'));
    }

}

