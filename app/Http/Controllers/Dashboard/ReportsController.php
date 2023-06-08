<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use App\reports;
use App\report_users;
class ReportsController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('report'), 403);
         
        $type = request()->get('type');
        $data = reports::where('section',$type)->orderBy('id','DESC')->get();

        return view('dashboard.reports.index', compact('data','type'));
    }


   public function report_users(Request $request){
         abort_if(!auth()->user()->hasPermission('appUsers_reports'), 403);
       
       
        $data = report_users::where('status',0)->orderBy('id','DESC')->get();
        return view('dashboard.reports.report_users', compact('data'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
          abort_if(!auth()->user()->hasPermission('create_report'), 403);
        $type = request()->get('type');
        return view('dashboard.reports.add', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('create_report'), 403);
         
            $request->validate([
                'name_ar'=>'required',
                'name_en'=>'required',
                'type'=>'required',
        ]);
        
        
        reports::create([
                'name_ar'       => $request->name_ar,
                'name_en'       => $request->name_en,
                'section'      => $request->section,
                'type'          => $request->type,
            ]);
        
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.reports.index',['type'=>$request->section]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         abort_if(!auth()->user()->hasPermission('update_report'), 403);
         
            $type = request()->get('type');
            $data = reports::find($id);
            return view('dashboard.reports.update', compact('type','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->hasPermission('update_report'), 403);
        
        $data = reports::find($id);
        $request->validate([
                'name_ar'=>'required',
                'name_en'=>'required',
                'type'=>'required',
        ]);
        
        
       $data->update([
                'name_ar'       => $request->name_ar,
                'name_en'       => $request->name_en,
                'section'      => $request->section,
                'type'          => $request->type,
            ]);
        
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.reports.index',['type'=>$request->section]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->hasPermission('delete_report'), 403);
        
        $data = reports::find($id);
        $data->delete();
        
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
    }
}
