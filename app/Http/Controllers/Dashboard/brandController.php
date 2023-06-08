<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\carBrands;
use App\Models\Catgories;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class brandController extends Controller
{
    use imageTrait;
    public function index(Request $request)
    {
        $allCatgories = carBrands::when($request->search, function ($query) use ($request) {

            return $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.brands.index', compact('allCatgories'));
    }


    public function create()
    {
        $categories=Catgories::all()->where('parent_id',null);
        return view('dashboard.brands.add',compact('categories'));
    }


    public function store(Request $request)
    {
      $request->validate([
          'cat_id'   =>'required|numeric',
          'name_ar'  =>'required',
          'name_en'  =>'required',
          'img'      =>'required',

      ]);

      $date=$request->except('_token','img');
      if ($request->has('img')){
          $imagname=$this->storeImages($request->img,'uploads/brands/');
          $date['img']=$imagname;
      }

      $brand=carBrands::create($date);
      if ($brand){
          session()->flash('success', __('site.added_successfully'));
          return redirect()->route('dashboard.brands.index');
      }


    }


    public function show(carBrands $carsBrands)
    {
        //
    }


    public function edit($carsBrands)
    {
        $catgoiry=carBrands::find($carsBrands);
        $categories=Catgories::all()->where('parent_id',null);
        return view('dashboard.brands.update', compact('catgoiry','categories'));
    }


    public function update(Request $request,$carsBrands)
    {
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',

        ]);
        $date=$request->except('_token','img');
        if ($request->has('img')){
            $imagname=$this->storeImages($request->img,'uploads/brands/');
            $date['img']=$imagname;
        }
        $catgoiry=carBrands::find($carsBrands);
        $brand=$catgoiry->update($date);
        if ($brand){

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.brands.index');
        }
    }


    public function destroy($carsBrands)
    {
      $destory=carBrands::destroy($carsBrands);
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.brands.index');
    }
}
