<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Banar;
use App\Models\Catgories;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\File; 
class banarController extends Controller
{
    use imageTrait;
    public function index(Request $request){
        
        abort_if(!auth()->user()->hasPermission('read_banars'), 403);
        $cat_id = $request->get('cat_id');
        if(empty($cat_id)){
             $banars=Banar::whereNull('cat_id')->orderBy('ordered','ASC')->get();
        }else{
             $banars=Banar::where('cat_id',$cat_id)->orderBy('ordered','ASC')->get();
        }
       
        return view('dashboard.banar.index',compact('banars','cat_id'));
    }
    
       public function order_banners(Request $request){
        
         abort_if(!auth()->user()->hasPermission('arrange_banars'), 403);
         
         
        $cat_id = $request->get('cat_id');
        if(empty($cat_id)){
             $data=Banar::whereNull('cat_id')->orderBy('ordered','ASC')->get();
        }else{
             $data=Banar::where('cat_id',$cat_id)->orderBy('ordered','ASC')->get();
        }
       
        return view('dashboard.banar.ordering',compact('data','cat_id'));
    }
    
     public function storeorder_banners(Request $request){
              
                abort_if(!auth()->user()->hasPermission('arrange_banars'), 403);
                
            $i=1;
            foreach($request->ids as $q){
                Banar::find($q)->update([
                            'ordered'=> $i
                    ]);
                $i++;
            }
            
            session()->flash('success', __('site.updated_successfully'));
           if(empty($request->cat_id)){
                return redirect()->route('dashboard.banar.index');
            }else{
                return redirect()->route('dashboard.banar.index',['cat_id'=>$request->cat_id]);
            }
    
    }

    public function create(Request $request){
        
          abort_if(!auth()->user()->hasPermission('create_banars'), 403);
          
        $cat_id = $request->get('cat_id');
        $categories=Catgories::whereNull('parent_id')->get();
        return view('dashboard.banar.add',compact('categories','cat_id'));
    }


    public function store(Request $request)
    {
        
         abort_if(!auth()->user()->hasPermission('create_banars'), 403);
        $request->validate([
        'img'        =>     'required',
        'days'        =>     'required',
        ]);
        
            $end_date = Carbon::now()->addDays($request->days + 1);
    
            $image=$this->storeImages($request->img,'laytwfk/public/uploads/banars/');
            $banar=Banar::create([
                'img'               =>   $image,
                'cat_id'            =>   $request->cat_id,
                'link'              =>   $request->link,
                'end_date'          =>   $end_date
            ]);
               
                session()->flash('success', __('site.added_successfully'));
                if(empty($request->cat_id)){
                    return redirect()->route('dashboard.banar.index');
                }else{
                    return redirect()->route('dashboard.banar.index',['cat_id'=>$request->cat_id]);
                }
                
    }


    public function show($banar)
    {
        //
    }


    public function edit(Request $request , $banar)
    {
        
         abort_if(!auth()->user()->hasPermission('update_banars'), 403);
         
        $cat_id = $request->get('cat_id');
        $categories=Catgories::whereNull('parent_id')->get();
        $catgoiry=Banar::find($banar);
        
        
        $to = Carbon::parse($catgoiry->end_date);
        $from = Carbon::parse($catgoiry->created_at);

     
        $days = $to->diffInDays($from);
        
        return view('dashboard.banar.update',compact('categories','catgoiry','cat_id','days'));
    }


    public function update(Request $request,$banar)
    {
        abort_if(!auth()->user()->hasPermission('update_banars'), 403);
 
        $request->validate([
            'days'        =>     'required',
        ]);

           
            $banarx=Banar::find($banar);
            
            $end_date = Carbon::parse($banarx->created_at)->addDays($request->days + 1);
             
            if(!empty($request->img)){
                
            if (File::exists('laytwfk/public/uploads/banars/'.$banarx->img)) {
                 File::delete('laytwfk/public/uploads/banars/'.$banarx->img);
             }
              $image=$this->storeImages($request->img,'laytwfk/public/uploads/banars/');
                $banarx->update([
                'img'       =>   $image,
               ]);
            }
           
               $banarx->update([
                    'cat_id'       =>   $request->cat_id,
                    'link'       =>   $request->link,
                    'end_date'          =>   $end_date
            ]);
          
       
        
            session()->flash('success', __('site.added_successfully'));

         if(empty($request->cat_id)){
            return redirect()->route('dashboard.banar.index');
        }else{
            return redirect()->route('dashboard.banar.index',['cat_id'=>$request->cat_id]);
        }

    }

    public function destroy($banar)
    {
         abort_if(!auth()->user()->hasPermission('delete_banars'), 403);
         
        Banar::destroy($banar);
        return redirect()->back()->with('success',__('site.deleted successfully'));
    }
}
