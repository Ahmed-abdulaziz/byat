<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use App\copons;
use App\copon_users;
use App\Models\appUsers;
class CoponsController extends Controller
{
       use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(!auth()->user()->hasPermission('read_copons'), 403);
         
        $copons = copons::orderBy('id','DESC')->get();

        return view('dashboard.copons.index', compact('copons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          abort_if(!auth()->user()->hasPermission('create_copons'), 403);
          return view('dashboard.copons.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
              abort_if(!auth()->user()->hasPermission('create_copons'), 403);
           $request->validate([
                'code'=>'required|unique:copons,code',
                'balance'=>'required',
                'end_date'=>'required| after:' . date('Y-m-d'),
        ]);
        
        
        copons::create([
                'code'      => $request->code,
                'balance'   => $request->balance,
                'end_date'  => $request->end_date,
            ]);
        
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.copons.index');
    
    }
    
    
     public function reports(Request $request){
         
           abort_if(!auth()->user()->hasPermission('Coupon_reports'), 403);
           
           
          $data = copon_users::orderBy('id','DESC')->get();
         if($request->user){
             $data = copon_users::where('user_id',$request->user)->whereBetween('created_at', [$request->start_date, $request->end_date])->orderBy('id','DESC')->get();
         }
       
        $users = appUsers::get();

        return view('dashboard.copons.reports', compact('data','users'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
