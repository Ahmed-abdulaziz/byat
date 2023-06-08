<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\city;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class citesController  extends Controller
{

    public function index(Request $request)
    {
        $allCatgories = city::when($request->search, function ($query) use ($request) {

            return $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%');

        })->orderBy('name_ar')->orderBy('name_en')->latest()->get();

        return view('dashboard.cites.index', compact('allCatgories'));
    }


    public function create()
    {
     //   $catgory=city::all()->where('parent_id','=',null);
        return view('dashboard.cites.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',

        ]);
        $date=$request->except('_token');
        $city=city::create($date);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.cites.index');

    }


    public function show(city $city)
    {
        //
    }


    public function edit($city)
    {
        $city=city::find($city);
       return view('dashboard.cites.update',compact('city'));
    }


    public function update(Request $request,$city)
    {
        $date=$request->except('_token');
        $city=city::find($city);
        $del=$city->update($date);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.cites.index');

    }


    public function destroy($city)
    {
          $del=city::destroy($city);

             session()->flash('success', __('site.deleted_successfully'));
         return redirect()->route('dashboard.cites.index');
    }
}
