<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\free_advertisments;
use App\Traits\notifcationTrait;
use App\Models\appUsers;
use App\Notifications;
class FreeAdvertismentsController extends Controller
{
     use notifcationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(!auth()->user()->hasPermission('read_adv_free'), 403);
        $data = free_advertisments::orderBy('month','DESC')->get();
        return view('dashboard.free-advertisments.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          abort_if(!auth()->user()->hasPermission('create_adv_free'), 403);
          
        return view('dashboard.free-advertisments.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('create_adv_free'), 403);
         
           $validated = $request->validate([
            'number' => 'required|integer|min:1',
            'month' => 'required|unique:free_advertisments',
        ]);
        
        free_advertisments::create([
                'number'=>$request->number,
                'month'=>$request->month,
            ]);
        
        $title= 'Laytwfk App';
        $this->broadCastNotification($title,$request->notifcatoion,'laytwfkApp');
        $month = $request->month;
        $number = $request->number;
 
        // $msg = "عميلنا العزيز ، تهانينا لك  \n لقد  حصلت على عدد $number  إعلان مجاني هدية لك من إدارة تطبيق لا يطوفك \n يمكنك الاستمتاع بإضافة هذه الإعلانات خلال شهر  $month";
        
        $msg = "لقد حصلت علي $number إعلان مجاني يمكنك استخدامه خلال شهر $month تطبيق لايطوفك";
        
         $users=appUsers::get();
         foreach($users as $user){
             Notifications::create([
                    'msg'=> $msg,
                    'title'=> $title,
                    'user_id'=> $user->id
                 ]);
         }
         
         
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.FreeAdvertisments.index');
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
         abort_if(!auth()->user()->hasPermission('update_adv_free'), 403);
         
        $data = free_advertisments::find($id);
        return view('dashboard.free-advertisments.update', compact('data'));
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
         abort_if(!auth()->user()->hasPermission('update_adv_free'), 403);
         
          $validated = $request->validate([
            'number' => 'required|integer|min:1',
            'month' => 'required|unique:free_advertisments,month,'.$id,
        ]);
        
        $data = free_advertisments::find($id);
        
       $data->update([
                'number'=>$request->number,
                'month'=>$request->month,
            ]);
            
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.FreeAdvertisments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         abort_if(!auth()->user()->hasPermission('delete_adv_free'), 403);
         
            $data=free_advertisments::find($id);
            $data->delete();
            return redirect()->back()->with('success',__('site.deleted successfully'));
    }
}
