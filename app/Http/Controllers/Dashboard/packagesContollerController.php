<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Packages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banks;
use App\packages_subscription;
use App\Models\appUsers;
use Carbon\Carbon;
use App\Advertisments;
use Illuminate\Support\Facades\File; 
use App\Traits\imageTrait;
class packagesContollerController extends Controller
{
 use imageTrait;
    public function index(Request $request)
    {
        $allCatgories =Packages::when($request->search, function ($query) use ($request) {

            return $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%');

        })->paginate(5);

        return view('dashboard.packages.index', compact('allCatgories'));
    }



  public function subscriptions_reports($type)
    {
         abort_if(!auth()->user()->hasPermission('app_reports'), 403);
         
         
           $all_data = packages_subscription::where('type',$type)->where('status',1)->get();
        
               foreach( $all_data as $data){
                    //     $auction_images = $data->images;
                    // // $data->images = asset('uploads/auctions/'.$data->img);
                    
                        $package= Packages::find($data->package_id);
                      
                  if (app()->getLocale() == 'ar') {
                      
                            
                                     if($package){
                                            $data->package_name = $package->name_ar;
                                     }else{
                                          $data->package_name = 'هذة الباقه غير موجوده';
                                     }
                  }else {
                                     if($data->package){
                                            $data->package_name = $package->name_en;
                                     }else{
                                         $data->package_name = 'Not Found Package';
                                     }
                  }
                          if($package){
                                        $data->package_adv_num = $package->adv_num;
                                        $data->package_price = $package->price;
                                        $data->type = $package->type;
                                        $data->period = $package->period;
                          }
                            
                                   $user = appUsers::find($data->user_id);
                                   if($user){
                                            $data->user_name = appUsers::where('id',$data->user_id)->first()->name;
                                            $data->user_phone = appUsers::where('id',$data->user_id)->first()->phone;
                                   }
                                    
                          $Banks= Banks::find($data->bank_id);
                             
                             
                          if($Banks){
                                    $data->bank_name = Banks::where('id',$data->bank_id)->first()->name;
                                     $data->img = asset('uploads/packages_subscriptions/'.$data->image);
                          }
                          
                            unset ($data->image);
                            unset( $data->package_id);
                            unset( $data->user_id);
                            unset ($data->bank_id);

                $subscriptions[] =   $data;
                    
            }
            
            // $auctions = $auctions->paginate(5);
            //  return($subscriptions);
          
   

          return view('dashboard.packages.subscriptions-reports', compact('subscriptions'));
    }
    

    
    public function subscriptions()
    {
        
           $all_data = packages_subscription::get();
        
               foreach( $all_data as $data){
                    //     $auction_images = $data->images;
                    // // $data->images = asset('uploads/auctions/'.$data->img);
                    
                        $package= Packages::find($data->package_id);
                      
                  if (app()->getLocale() == 'ar') {
                      
                            
                                     if($package){
                                            $data->package_name = $package->name_ar;
                                     }else{
                                          $data->package_name = 'هذة الباقه غير موجوده';
                                     }
                  }else {
                                     if($data->package){
                                            $data->package_name = $package->name_en;
                                     }else{
                                         $data->package_name = 'Not Found Package';
                                     }
                  }
                          if($package){
                                        $data->package_adv_num = $package->adv_num;
                                        $data->package_price = $package->price;
                                        $data->type = $package->type;
                                        $data->period = $package->period;
                          }
                            
                                     $user= appUsers::find($data->user_id);
                                     if($user){
                                            $data->user_name = $user->name;
                                            $data->user_phone = $user->phone;
                                     }
                                   
                                    $Banks= Banks::find($data->bank_id);
                             
                             
                          if($Banks){
                                    $data->bank_name = Banks::where('id',$data->bank_id)->first()->name;
                                     $data->img = asset('uploads/packages_subscriptions/'.$data->image);
                          }
                          
                            unset ($data->image);
                            unset( $data->package_id);
                            unset( $data->user_id);
                            unset ($data->bank_id);

                $subscriptions[] =   $data;
                    
            }
            
            // $auctions = $auctions->paginate(5);
            //  return($subscriptions);
          
   

          return view('dashboard.packages.subscriptions', compact('subscriptions'));
    }
    
      public function active_subscriptions(Request $request,$id){
          
         
            $package=packages_subscription::find($id);
            $user = appUsers::where('id',$package->user_id)->first();
            $main_package = Packages::where('id',$package->package_id)->first();
         if($request->status  == 1){
                
                          if($package->type == 0){
                   
                     $old_adv = $user->adv_number;
                     $total = $old_adv + $main_package->adv_num;
                     
                      $user->update([
                      'adv_number' => $total
                     ]);
                 }elseif($package->type == 1){
                     
                     $old_auction = $user->auctions_number;
                     $total = $old_auction + $main_package->adv_num;
                     
                      $user->update([
                      'auctions_number' => $total
                     ]);
                 }elseif($package->type == 2){
                    
                        $adv_id = $package->adv_id;
                        $days = $main_package->period;
                        $adv=Advertisments::find($adv_id);
                        $end_date_of_star = Carbon::now()->addDays($days)->format('Y-m-d');  
                          $adv->update([
                          'star' => 1,
                          'end_star'=>$end_date_of_star
                         ]);
                 }
                  $package->update([
                      'status' => 1
                     ]);
             
         }elseif($request->status  == 2){
             $package->update([
                      'status' =>2
                     ]);
         }
       
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.subscriptions');
    }
    public function create()
    {
        return view('dashboard.packages.add');
    }


    public function store(Request $request)
    {
        $request->validate([
                'name_ar'           =>      'required',
                'name_en'           =>      'required',
                'color'             =>      'required',
                'img'             =>      'required',
                'details'           =>      'required',
                'price'             =>      'required',
                'type'              =>      'required',
        ]);
       
        $image=$this->storeImages($request->img,'laytwfk/public/uploads/packages/');
      if ($request->type != 2){
          $request->validate([
              'adv_num'           =>      'required|numeric',
          ]);
           $save=Packages::create([
                'name_ar'       => $request->name_ar,
                'name_en'       => $request->name_en,
                'image'         => $image,
                'color'         => $request->color,
                'details'       => $request->details,
                'type'          => $request->type,
                'price'         => $request->price,
                'adv_num'       => $request->adv_num,
               ]);
           session()->flash(__('site.added_successfully'));
           return redirect()->route('dashboard.packages.index');

      }elseif ($request->type==2){
        $request->validate([
              'period'           =>      'required|numeric',
          ]);
          
            $save=Packages::create([
                'name_ar'       => $request->name_ar,
                'name_en'       => $request->name_en,
                'image'         => $image,
                'color'         => $request->color,
                'details'       => $request->details,
                'type'          => $request->type,
                'price'         => $request->price,
                'period'       => $request->period,
               ]);
            session()->flash(__('site.added_successfully'));
            return redirect()->route('dashboard.packages.index');
      }
    }


    public function show(Packages $packages)
    {

    }


    public function edit($packages)
    {
        $packages=Packages::find($packages);
        return view('dashboard.packages.update',compact('packages'));
    }


    public function update(Request $request,$packages)
    {
           $request->validate([
                'name_ar'           =>      'required',
                'name_en'           =>      'required',
                'color'             =>      'required',
                'details'           =>      'required',
                'price'             =>      'required',
        ]);
       
       
        $packages=Packages::find($packages);
        
         if(!empty($request->img)){
               if (File::exists('laytwfk/public/uploads/packages/'.$packages->image)) {
                     File::delete('laytwfk/public/uploads/packages/'.$packages->image);
                 }
             
              $image=$this->storeImages($request->img,'laytwfk/public/uploads/packages/');
               $packages->update([
                    'image'         => $image,
               ]);
         }
      
      if ($packages->type != 2){
          $request->validate([
              'adv_num'           =>      'required|numeric',
          ]);
          $packages->update([
                'name_ar'       => $request->name_ar,
                'name_en'       => $request->name_en,
                'color'         => $request->color,
                'details'       => $request->details,
                'price'         => $request->price,
                'adv_num'       => $request->adv_num,
               ]);
           session()->flash(__('site.added_successfully'));
           return redirect()->route('dashboard.packages.index');

      }elseif ($packages->type==2){
        $request->validate([
              'period'           =>      'required|numeric',
          ]);
          
           $packages->update([
                'name_ar'       => $request->name_ar,
                'name_en'       => $request->name_en,
                'color'         => $request->color,
                'details'       => $request->details,
                'price'         => $request->price,
                'period'       => $request->period,
               ]);
            session()->flash(__('site.added_successfully'));
            return redirect()->route('dashboard.packages.index');
      }
 
        session()->flash(__('site.updated_successfully'));
        return redirect()->route('dashboard.packages.index');
    }


    public function destroy($packages)
    {   
         $packages=Packages::find($packages);
          if (File::exists('laytwfk/public/uploads/packages/'.$packages->image)) {
                     File::delete('laytwfk/public/uploads/packages/'.$packages->image);
                 }
          Packages::destroy($packages);
          session()->flash(__('site.added_successfully'));
          return redirect()->route('dashboard.packages.index');

    }
}
