<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Carstatus;
use App\Models\realstateperiod;
use App\Models\realstatetype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RealStatePeriodController extends Controller
{

    public function index(Request $request)
    {
        $allCatgories = realstateperiod::when($request->search, function ($query) use ($request) {

            return $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);
        return view('dashboard.realstateperiod.index', compact('allCatgories'));
    }


    public function create()
    {
        return view('dashboard.realstateperiod.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',

        ]);

        $date=$request->except('_token');
        $brand=realstateperiod::create($date);
        if ($brand){

            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.realstateperiod.index');
        }

    }


    public function show(Carstatus $carstatus)
    {
        //
    }


    public function edit( $carstatus)
    {
        $catgoiry=realstateperiod::find($carstatus);
        return view('dashboard.realstateperiod.update', compact('catgoiry'));
    }


    public function update(Request $request,  $carstatus)
    {
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',

        ]);
        $date=$request->except('_token');
        $catgoiry=realstateperiod::find($carstatus);
        $brand=$catgoiry->update($date);
        if ($brand){

            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.realstateperiod.index');
        }
    }

    public function destroy($carstatus)
    {
        $destory=realstateperiod::destroy($carstatus);
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.realstateperiod.index');
    }
}
