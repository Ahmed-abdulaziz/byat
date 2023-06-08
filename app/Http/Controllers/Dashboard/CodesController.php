<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\codes;
class CodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->hasPermission('read_codes'), 403);
        
        $codes = codes::orderBy('user_id','ASC')->orderBy('amount','DESC')->get();
        return view('dashboard.codes.index',compact('codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->hasPermission('create_codes'), 403);
        return view('dashboard.codes.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('create_codes'), 403);
         
         
         $request->validate([
           'codes'             =>   'required|integer',
           'amount'            =>   'required|numeric',
       ]);
       
        for($i = 0; $i < $request->codes ;$i++){
            
        
                        // String of all alphanumeric character 
                        $int_result = '0123456789';
                        $str_result = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                         code:
                        $strval =  substr(str_shuffle($str_result),  
                        0, 2);
               
                        $intval = '';
                        array_map(function($value) use(&$intval){
                            $intval.=mt_rand(0, 9);
                        }, range(0,13));

                        $code = $strval.''.$intval;
                        $check = codes::where('code',$code)->count();
                        
                        if($check < 1){
                           // insert
                                codes::create([
                                    'code'    => $code,
                                    'amount'  => $request->amount
                                ]);
                        
                        }else{
                            goto  code;
                        }
                    
        }
             return redirect()->route('dashboard.codes');
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
    public function destroy($id){
        
         abort_if(!auth()->user()->hasPermission('delete_codes'), 403);
         
        $code = codes::find($id);
        if(empty($code->user_id)){
            $code->delete();
             session()->flash('success', __('site.deleted_successfully'));
        }
        
        return redirect()->back();
        
    }
}
