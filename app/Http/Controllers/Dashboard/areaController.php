<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\dashborad\Areacityhandler;
use App\Models\area;
use App\Models\city;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class areaController extends Controller
{
    use GeneralTrait;

    public function index(Request $request)
    { 
          abort_if(!auth()->user()->hasPermission('read_area'), 403);
          
        $citeis=city::all();
        $allareas = area::when($request->city_id, function ($q) use ($request) {
                return $q->where('city_id', $request->city_id );
        })->latest()->get();
        //$Areacityhandler=Areacityhandler::collection($allareas);
        return view('dashboard.Areas.index', compact('allareas','citeis'));
    }


    public function create()
    {
         abort_if(!auth()->user()->hasPermission('create_area'), 403);
        $citeis=city::all();
        return view('dashboard.Areas.add',compact('citeis'));
    }


    public function store(Request $request)
    {
         abort_if(!auth()->user()->hasPermission('create_area'), 403);
        $newMaincatgory=area::create([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'city_id'=>$request->city_id,

        ]);

        if ($newMaincatgory){
            return redirect()->route('dashboard.area.index')->with(['success'=>'تمت الاضافه بنجاح']);
        }

    }

    public function show(Area $area)
    {

    }


    public function edit($area)
    {
         abort_if(!auth()->user()->hasPermission('update_area'), 403);
        $citeis=city::all();
        $maino=area::find($area);
        return view('dashboard.Areas.update',compact('maino','citeis','area'));

    }


    public function update(Request $request,$area)
    {
        abort_if(!auth()->user()->hasPermission('update_area'), 403);
        $request->validate([

            'name_ar' =>   'required',
            'name_en' =>   'required',
            'city_id' =>   'required',

        ]);
        $update=DB::table('areas')->where('id','=',$area)->update(['name_ar'=>$request->name_ar,'name_en'=>$request->name_en,'city_id'=>$request->city_id]);
        return redirect()->route('dashboard.area.index')->with(['success'=>'تم التحديث بنجاح']);
    }


    public function destroy($area)
    {
        abort_if(!auth()->user()->hasPermission('delete_area'), 403);
        
        $delete=DB::table('areas')->where('id','=',$area)->delete();
        return redirect()->route('dashboard.area.index')->with(['success'=>'تم الحذف بنجاح']);
    }
}
