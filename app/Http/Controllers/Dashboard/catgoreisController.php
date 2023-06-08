<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\Carcolors;
use App\Models\Catgories;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 

use App\category_item_components;
use App\category_items;
use App\category_item_inputs;
class catgoreisController extends Controller
{
    use imageTrait;

    public function index(Request $request)
    {
            abort_if(!auth()->user()->hasPermission('read_categories'), 403);
            
         $type = $request->get('type');
        $allCatgories = Catgories::withTrashed()->where('parent_id',$type)->whereNotNull('parent_id')->when($request->search, function ($query) use ($request) {

            return $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%');

        })->orderBy('ordered','ASC')->paginate(10);

        return view('dashboard.catgoires.index', compact('allCatgories'));

    }



    public function create()
    {
           abort_if(!auth()->user()->hasPermission('create_categories'), 403);
        $catgory=Catgories::all()->where('parent_id','=',null);
        $ads=Catgories::all()->where('parent_id',1);
        $auctions=Catgories::all()->where('parent_id',2);
        return view('dashboard.catgoires.add',compact('catgory','ads','auctions'));
    }


    public function store(Request $request)
    {
                 abort_if(!auth()->user()->hasPermission('create_categories'), 403);
        
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'parent_id' => 'required|numeric',
            'img' => 'required',
        ]);    
            $parent = $request->parent_id;
             $parent = $request->parent_id;
             if(!empty($request->parent_id2)){
                     $request->parent_id = $request->parent_id2 ;
             }
             $image=$this->storeImages($request->img,'laytwfk/public/uploads/catgoires/');
             
             $catgory=Catgories::create([
                 'name_ar'=>$request->name_ar,
                 'name_en'=>$request->name_en,
                 'parent_id'=>$request->parent_id,
                 'img'=>$image,
                 'examination_image'=> $request->examination_image ? 1 : 0
                ]);
            
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.catgoiries.index',['type'=>$parent]);

    }


    public function show($Catgories)
    {
        $status=DB::table('catgoiries')->where('id',$Catgories)->value('active');
        if ($status==1){
            $about=DB::table('catgoiries')->where('id',$Catgories)->update(['active'=>0]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back();
        }else{
            $about=DB::table('catgoiries')->where('id',$Catgories)->update(['active'=>1]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back();
        }

    }

    public function subcat($parent){
        
            abort_if(!auth()->user()->hasPermission('arrange_categories'), 403);
         
            $catgory=Catgories::where('parent_id',$parent)->orderBy('ordered','ASC')->get();
            return view('dashboard.catgoires.ordering', compact('catgory', 'parent'));
        }
        
            
      public function storesubcat(Request $request){
             
                abort_if(!auth()->user()->hasPermission('arrange_categories'), 403);
                
                
                $i=1;
                foreach($request->ids as $q){
                    Catgories::find($q)->update([
                                'ordered'=> $i
                        ]);
                    $i++;
                }
                
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->back();
    
    }


    public function edit($Catgories)
    {
         abort_if(!auth()->user()->hasPermission('update_categories'), 403);
        $catgory=Catgories::all()->where('parent_id','=',null);
        $catgoiry=Catgories::find($Catgories);
        $ads=Catgories::where('parent_id',1)->where('id',"!=",$Catgories)->get();
        $auctions=Catgories::where('parent_id',2)->where('id',"!=",$Catgories)->get();
        $main_parent = Catgories::find($catgoiry->parent_id);
        if($main_parent){
            $main_parent = $main_parent->parent_id;
        }
        return view('dashboard.catgoires.update', compact('catgory','catgoiry','ads','auctions','main_parent'));
    }


    public function update(Request $request,$Catgories)
    {
         abort_if(!auth()->user()->hasPermission('update_categories'), 403);
         
         $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'parent_id' => 'required|numeric',
        ]);
        
         $catgorirs=Catgories::find($Catgories);
         
         $parent =   $request->parent_id;
         if(!empty($request->parent_id2)){
             $request->parent_id = $request->parent_id2  ;
         }
         

         if(!empty($request->img)){
             if(!empty($catgorirs->img)){
                 File::delete('uploads/catgoires/'.$catgorirs->img);
             }
                $image=$this->storeImages($request->img,'laytwfk/public/uploads/catgoires/');
                $catgorirs->update([
                 'img'=>$image,
                ]);
         }
         
         
         $catgorirs->update([
             'name_ar'=>$request->name_ar,
             'name_en'=>$request->name_en,
             'parent_id'=>$request->parent_id,
             'examination_image'=> $request->examination_image ? 1 : 0
            ]);
    

        session()->flash('success', __('site.updated_successfully'));
       
            return redirect()->route('dashboard.catgoiries.index',['type'=>$parent]);
    }
    
    
      public function hide_show($cat_id , $type){
            abort_if(!auth()->user()->hasPermission('hide_categories'), 403);
           if($type == 0){
                Catgories::destroy($cat_id);
           }else{
               Catgories::withTrashed()->find($cat_id)->restore();
           }
           
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back();
        
       }
       
       
    public function destroy($Catgories)
    {
         abort_if(!auth()->user()->hasPermission('delete_categories'), 403);
         
        $cat = Catgories::withTrashed()->find($Catgories);
        $cat->forceDelete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
    }
    
    // -----------------------------
    
       public function filters($cat_id){
        abort_if(!auth()->user()->hasPermission('read_filters'), 403);
        $data = category_items::where('cat_id',$cat_id)->orderBy('ordered','ASC')->get();
        return view('dashboard.catgoires.filters.index', compact('data','cat_id'));

    }
    
      public function add_filters($cat_id){
          
         abort_if(!auth()->user()->hasPermission('create_filters'), 403);
        $category_items = category_items::where('cat_id',$cat_id)->wherenull('parent_category_items')->orderBy('ordered','ASC')->get();
        return view('dashboard.catgoires.filters.add',compact('cat_id','category_items'));
    }
    
    public function GetCategoryItems(Request $request){
          
        abort_if(!auth()->user()->hasPermission('create_filters'), 403);
           
        $category_items = category_item_components::where('category_item_id',$request->catgory)->get();
        
       // Fetch all records
            $Data['data'] = $category_items;

            echo json_encode($Data);
            exit;
    }
    
     public function store_filters(Request $request ,$cat_id){
         
             abort_if(!auth()->user()->hasPermission('create_filters'), 403);
            $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'type' => 'required',
        ]);  
        
        // dd($request);
        
        $data = category_items::create([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'cat_id' => $request->cat_id,
                    'type' => $request->type,
                    'can_skip' => $request->can_skip == 1 ? 1 : 0,
                    'componant_have_image' => $request->have_images == 1 ? 1 : 0,
                    'check_fom' => $request->check_fom ? $request->check_fom  : 0,
                    'parent_category_items' => $request->main_filter ,
        ]);
        
        if($request->type != 3){
            
             if(!empty($request->items_name_ar)){
                 for($i=0;$i<count($request->items_name_ar);$i++){
                     if(!empty($request->images[$i])){
                                $image=$this->storeImages($request->images[$i],'laytwfk/public/uploads/catgoires/filter_selection');
                     }else{
                         $image = NULL;
                     }
                      category_item_components::create([
                         'name_ar'                      => $request->items_name_ar[$i],
                         'name_en'                      => $request->items_name_en[$i],
                         'parent_category_components'   => $request->parent_category_components[$i],
                         'category_item_id' => $data->id,
                         'image' => $image,
                    ]);
                }
            }
        
        }else{
                // category_item_inputs
                 if(!empty($request->inputs_title_ar)){
                 for($i=0;$i<count($request->inputs_title_ar);$i++){
                      category_item_inputs::create([
                        'title_ar' => $request->inputs_title_ar[$i],
                        'title_en' => $request->inputs_title_en[$i],
                        'placeholder_ar' => $request->inputs_placeholder_ar[$i],
                        'placeholder_en' => $request->inputs_placeholder_en[$i],
                        'unit_ar' => $request->inputs_unit_ar[$i],
                        'unit_en' => $request->inputs_unit_en[$i],
                        'category_item_id' => $data->id,
                    ]);
                }
            }
        }
       
       
        
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.filters',$cat_id);
        
    }
    
     public function edit_filters($id){
          abort_if(!auth()->user()->hasPermission('update_filters'), 403);
          
        $data = category_items::find($id);
        if($data->type == 1 || $data->type == 2){
             $componants = category_item_components::where('category_item_id',$id)->get();
        }else{
             $componants = category_item_inputs::where('category_item_id',$id)->get();
        }
        
        $category_items = category_items::where('cat_id',$data->cat_id)->wherenull('parent_category_items')->orderBy('ordered','ASC')->get();
        
        $parent_category_items = '';
        if(!empty($data->parent_category_items)){

            $parent_category_items = category_item_components::where('category_item_id',$data->parent_category_items)->get();
        } 
        
       
       
        return view('dashboard.catgoires.filters.update',compact('data','category_items','componants','parent_category_items'));
    }
    
     public function update_filters(Request $request ,$id){
         
          abort_if(!auth()->user()->hasPermission('update_filters'), 403);
        
            $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'type' => 'required',
        ]);  
        
         $data = category_items::find($id);
        
        $data->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'type' => $request->type,
                'can_skip' => $request->can_skip == 1 ? 1 : 0,
                'componant_have_image' => $request->have_images == 1 ? 1 : 0,
                'check_fom' => $request->check_fom ? $request->check_fom  : 0,
                'parent_category_items' => $request->main_filter ,
        ]);
        
   
        if($request->type != 3){
            
             if(!empty($request->items_name_ar)){
                 for($i=0;$i<count($request->items_name_ar);$i++){
                     if(!empty($request->images[$i])){
                                $image=$this->storeImages($request->images[$i],'laytwfk/public/uploads/catgoires/filter_selection');
                     }else{
                         $image = NULL;
                     }
                      category_item_components::create([
                         'name_ar'                      => $request->items_name_ar[$i],
                         'name_en'                      => $request->items_name_en[$i],
                         'parent_category_components'   => $request->parent_category_components[$i],
                         'category_item_id' => $data->id,
                         'image' => $image,
                    ]);
                }
            }
        
        }else{
                // category_item_inputs
                 if(!empty($request->inputs_title_ar)){
                 for($i=0;$i<count($request->inputs_title_ar);$i++){
                      category_item_inputs::create([
                        'title_ar' => $request->inputs_title_ar[$i],
                        'title_en' => $request->inputs_title_en[$i],
                        'placeholder_ar' => $request->inputs_placeholder_ar[$i],
                        'placeholder_en' => $request->inputs_placeholder_en[$i],
                        'unit_ar' => $request->inputs_unit_ar[$i],
                        'unit_en' => $request->inputs_unit_en[$i],
                        'category_item_id' => $data->id,
                    ]);
                }
            }
        }
       
        
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.filters',$data->cat_id);
        
    }
    
      public function update_componant_filter(Request $request ){
         
          abort_if(!auth()->user()->hasPermission('update_filters'), 403);
          
          
        if($request->type == 1 || $request->type == 2){     // single or multi selection
            
                 $data      = category_item_components::find($request->componant_id);
                 $fieldname = $request->fieldname;
                
                $data->update([
                     "$fieldname" => $request->value,
                ]);
                
        
        }else{      // text
            
            
                 $data      = category_item_inputs::find($request->componant_id);
                 $fieldname = $request->fieldname;
                
                $data->update([
                     "$fieldname" => $request->value,
                ]);
                
                
        }
       

        return __('site.updated_successfully');
        
    }
    
      public function update_componant_image(Request $request ){
         
                abort_if(!auth()->user()->hasPermission('update_filters'), 403);
                
                 $data      = category_item_components::find($request->componant_id);
                 

                if(!empty($request->image)){
                         $image=$this->storeImages($request->image,'laytwfk/public/uploads/catgoires/filter_selection');
                         if (file_exists('laytwfk/public/uploads/catgoires/filter_selection'.$data->image)) {
                            unlink('laytwfk/public/uploads/catgoires/filter_selection'.$data->image);
                        } 
                        
                        $data->update(['image'=>$image]);
                    }

      

        //   return session()->flash('success', __('site.updated_successfully'));
        return __('site.updated_successfully');
        
    }
    
    
      public function delete_componant_filter(Request $request ){
          abort_if(!auth()->user()->hasPermission('update_filters'), 403);
          
        if($request->type == 1 || $request->type == 2){     // single or multi selection
            
                 $data      = category_item_components::find($request->componant_id);
                 
                if(!empty($data->image)){
                             if (file_exists('laytwfk/public/uploads/catgoires/filter_selection'.$data->image)) {
                                unlink('laytwfk/public/uploads/catgoires/filter_selection'.$data->image);
                            } 
                        }
                 $data->delete();
        
        }else{      // text
            
                $data      = category_item_inputs::find($request->componant_id);
                $data->delete();
                
        }
       

        return __('site.deleted_successfully');
        
    }
    
   
        public function order_filters($cat_id){
        
        
        
        abort_if(!auth()->user()->hasPermission('arrange_filters'), 403);
         
        $data = category_items::where('cat_id',$cat_id)->orderBy('ordered','ASC')->get();
        return view('dashboard.catgoires.filters.ordering', compact('data','cat_id'));

        }
        
         public function storeorder_filters(Request $request , $cat_id){
              
            $i=1;
            foreach($request->ids as $q){
                category_items::find($q)->update([
                            'ordered'=> $i
                    ]);
                $i++;
            }
            
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.filters',$cat_id);
    
    }
    
     public function destroy_filters($id){
        abort_if(!auth()->user()->hasPermission('delete_filters'), 403);
        
        category_items::destroy($id);
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
    }
}
