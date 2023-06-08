<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Monthly_withdrawals;
use App\Winner_Monthly_withdrawals;
use App\bills;
use Carbon\Carbon;
class MonthlyWithdrawalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(!auth()->user()->hasPermission('read_monthly_withdrawals'), 403);
         
            $data = Monthly_withdrawals::orderBy('month' , 'DESC')->get();
            
            return view('dashboard.Monthly-withdrawals.index', compact('data'));
    }

    
    public function competitor($id)
    {
        abort_if(!auth()->user()->hasPermission('show_competitor_monthly_withdrawals'), 403);
        
            $data = Monthly_withdrawals::find($id);
            $bills = bills::where('created_at', 'like', '%' . $data->month . '%' )->distinct()->get(['user_id']);
      
            return view('dashboard.Monthly-withdrawals.competitor', compact('data','bills'));
    }
   
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->hasPermission('create_monthly_withdrawals'), 403);
        
         return view('dashboard.Monthly-withdrawals.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->hasPermission('create_monthly_withdrawals'), 403);
        
           $validated = $request->validate([
            'month' => 'required|unique:monthly_withdrawals',
        ]);
        
        Monthly_withdrawals::create([
                'month'=>$request->month,
            ]);

         
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.MonthlyWithdrawals.index');
    }

    public function random_winner(Request $request)
    {
        abort_if(!auth()->user()->hasPermission('choose_winner_monthly_withdrawals'), 403);
        
            $data = Monthly_withdrawals::find($request->monthly_withdrawals_id);
            $bills = bills::whereNotIn('user_id',Winner_Monthly_withdrawals::where('monthly_withdrawals_id',$request->monthly_withdrawals_id)
                            ->pluck('user_id'))
                            ->where('created_at', 'like', '%' . $data->month . '%' )
                            ->distinct()
                            ->inRandomOrder()
                            ->first(['user_id']);
        
            if($bills){
                    Winner_Monthly_withdrawals::create([
                        'user_id'                => $bills->user_id,
                        'monthly_withdrawals_id' => $request->monthly_withdrawals_id,
                    ]);
                return $bills->user;
            }           
            
    }
    
      public function winner($id){
          
           abort_if(!auth()->user()->hasPermission('show_winner_monthly_withdrawals'), 403);
           
            $data = Winner_Monthly_withdrawals::where('monthly_withdrawals_id', $id)->get();
            return view('dashboard.Monthly-withdrawals.winners',compact('data'));
    }
    
      public function close($id){
          
             abort_if(!auth()->user()->hasPermission('stop_monthly_withdrawals'), 403);
          
                $data = Monthly_withdrawals::find($id);
                $data->update(['status'=> 1]);
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->route('dashboard.MonthlyWithdrawals.index');
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
