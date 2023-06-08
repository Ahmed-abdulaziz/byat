<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\alladvertismetsResource;
use App\Http\Resources\singleAdvResource;
use App\Http\Resources\updateimagesResponse;
use App\Models\Advertisments;
use App\Models\Advimages;
use App\Models\Banadv;
use App\Models\Favoritesadv;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdvertimnetsController extends Controller
{
    use GeneralTrait;
    use imageTrait;
    public function create(Request $request)
    {
        $user_id = $this->getUserID($request->bearerToken());
        $rules = [
            'type' => 'required',
        ];
        $valdaitor = Validator::make($request->all(), $rules);
        if ($valdaitor->fails()) {
            $code = $this->returnCodeAccordingToInput($valdaitor);
            return $this->returnValidationError($code, $valdaitor);
        } else {

            if ($request->type == 0) {
                $rules = [
                    'title' => 'required',
                    'phone' => 'required',
                    'about' => 'required',
              //      'img' => 'required',
                    'cat_id' => 'required',
              //      'sub_id' => 'required',
                    'lat' => 'required',
                    'long' => 'required',
                    'address' => 'required',
                    'price' => 'required',
                    'advertismet_type' => 'required',
                    'brand_id' => 'required',
                    'model_id' => 'required',
                    'year' => 'required',
                    'status_id' => 'required',
                    'color_id' => 'required',
                    'shape_id' => 'required',
                    'door_number' => 'required',
                    'seat_number' => 'required',
                    'cartransmissions_id' => 'required',
                    'fueltype_id' => 'required',
                    'carenginetype_id' => 'required',
                    'whealsystemtype' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',
                ];
                $valdaitor = Validator::make($request->all(), $rules);
                if ($valdaitor->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdaitor);
                    return $this->returnValidationError($code, $valdaitor);
                } else {
                    $owner_type=DB::table('app_users')->where('id','=',$user_id)->value('type');
                    if ($owner_type==0){
                        $own=1;
                    }else{
                        $own=2;
                    }
                    $data = $request->except('img', 'realstattype_id', 'realstatperiod_id', 'roomnumber', 'roomnumber', 'placearea');
                    $data['user_id'] = $user_id;
                    $data['owner_type'] = $own;

                    $adv = Advertisments::create($data);
                    if ($adv) {
                     if (isset($request->img)){
                         foreach ($request->file('img') as $iamge) {
                             $imagname = $this->storeImages($iamge, 'uploads/adv/');
                             Advimages::create([
                                 'img' => $imagname,
                                 'adv_id' => $adv->id,
                             ]);
                             $adv->update(['has_image'=>1]);
                         }
                        }else{
                         $adv->update(['has_image'=>-1,]);
                     }
                    DB::table('app_users')->where('id','=',$user_id)->decrement('adv_number');
                    }
                    if (app()->getLocale() == 'ar') {
                        return $this->returnSuccessMessage('هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء.');
                    } else {
                        return $this->returnSuccessMessage('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');
                    }
                }


            } elseif ($request->type == 1) {

                $rules = [
                    'title' => 'required',
                    'phone' => 'required',
                    'about' => 'required',
                //    'img' => 'required',
                    'cat_id' => 'required',
                  //  'sub_id' => 'required',
                    'lat' => 'required',
                    'long' => 'required',
                    'address' => 'required',
                    'price' => 'required',
                    'advertismet_type' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',
                    'realstattype_id' => 'required',
                    'realstatepurpose' => 'required',
                    'roomnumber' => 'required',
                    'tolietnumber' => 'required',
                    'placearea' => 'required',
                ];
                $valdaitor = Validator::make($request->all(), $rules);
                if ($valdaitor->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdaitor);
                    return $this->returnValidationError($code, $valdaitor);
                } else {
                    $owner_type=DB::table('app_users')->where('id','=',$user_id)->value('type');
                    if ($owner_type==0){
                        $own=1;
                    }else{
                        $own=2;
                    }
                    $data = $request->only(['title', 'phone', 'about', 'cat_id', 'sub_id', 'lat', 'long', 'address', 'price', 'advertismet_type', 'city_id', 'area_id', 'realstattype_id', 'realstatepurpose', 'tolietnumber', 'placearea','type']);
                    $data['user_id'] = $user_id;
                    $data['owner_type'] = $own;
                    $adv = Advertisments::create($data);

                    if ($adv) {
                        if (isset($request->img)){
                            foreach ($request->file('img') as $iamge) {
                                $imagname = $this->storeImages($iamge, 'uploads/adv/');
                                Advimages::create([
                                    'img' => $imagname,
                                    'adv_id' => $adv->id,
                                ]);
                            }
                            $adv->update(['has_image'=>1]);
                        }else{
                            $adv->update(['has_image'=>-1,]);
                        }
                        if (isset($request->realstatperiod_id)){
                            $adv->realstatperiod_id=$request->realstatperiod_id;
                            $adv->save;
                        }
                        DB::table('app_users')->where('id','=',$user_id)->decrement('adv_number');
                    }
                    if (app()->getLocale() == 'ar') {
                        return $this->returnSuccessMessage('هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء.');
                    } else {
                        return $this->returnSuccessMessage('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');
                    }
                }
            } else {


                $rules = [
                    'title' => 'required',
                    'phone' => 'required',
                    'about' => 'required',
                 //   'img' => 'required',
                    'cat_id' => 'required',
                  //  'sub_id' => 'required',
                    'lat' => 'required',
                    'long' => 'required',
                    'address' => 'required',
                    'price' => 'required',
                    'advertismet_type' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',

                ];
                $valdaitor = Validator::make($request->all(), $rules);
                if ($valdaitor->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdaitor);
                    return $this->returnValidationError($code, $valdaitor);
                } else {
                    $owner_type=DB::table('app_users')->where('id','=',$user_id)->value('type');
                    if ($owner_type==0){
                        $own=1;
                    }else{
                        $own=2;
                    }
                    $data = $request->only(['title', 'phone', 'about', 'cat_id', 'sub_id', 'lat', 'long', 'address', 'price', 'advertismet_type', 'city_id', 'area_id','type']);
                    $data['user_id'] = $user_id;
                    $data['owner_type'] = $own;
                    $adv = Advertisments::create($data);
                    if ($adv) {
                        if (isset($request->img)){
                            foreach ($request->file('img') as $iamge) {
                                $imagname = $this->storeImages($iamge, 'uploads/adv/');
                                Advimages::create([
                                    'img' => $imagname,
                                    'adv_id' => $adv->id,
                                ]);
                            }
                            $adv->update(['has_image'=>1]);
                        }else{
                            $adv->update(['has_image'=>-1,]);
                        }
                        DB::table('app_users')->where('id','=',$user_id)->decrement('adv_number');
                    }
                   if (app()->getLocale() == 'ar') {
                        return $this->returnSuccessMessage('هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء.');
                    } else {
                        return $this->returnSuccessMessage('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');
                    }
                }
            }
        }
    }




    public function update(Request $request){
        $user_id = $this->getUserID($request->bearerToken());
        $rules = [
            'adv_id' => 'required',
        ];
        $valdaitor = Validator::make($request->all(), $rules);
        if ($valdaitor->fails()) {
            $code = $this->returnCodeAccordingToInput($valdaitor);
            return $this->returnValidationError($code, $valdaitor);
        } else {
            $adv=Advertisments::find($request->adv_id);
            $type=$adv->type;
            if ($type == 0) {
                $rules = [
                    'title' => 'required',
                    'phone' => 'required',
                    'about' => 'required',
                    //      'img' => 'required',
                    'cat_id' => 'required',
                    //      'sub_id' => 'required',
                    'lat' => 'required',
                    'long' => 'required',
                    'address' => 'required',
                    'price' => 'required',
                    'advertismet_type' => 'required',
                    'brand_id' => 'required',
                    'model_id' => 'required',
                    'year' => 'required',
                    'status_id' => 'required',
                    'color_id' => 'required',
                    'shape_id' => 'required',
                    'door_number' => 'required',
                    'seat_number' => 'required',
                    'cartransmissions_id' => 'required',
                    'fueltype_id' => 'required',
                    'carenginetype_id' => 'required',
                    'whealsystemtype' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',
                ];
                $valdaitor = Validator::make($request->all(), $rules);
                if ($valdaitor->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdaitor);
                    return $this->returnValidationError($code, $valdaitor);
                } else {
                    $owner_type=DB::table('app_users')->where('id','=',$user_id)->value('type');
                    if ($owner_type==0){
                        $own=1;
                    }else{
                        $own=2;
                    }
                    $data = $request->except('img', 'realstattype_id', 'realstatperiod_id', 'roomnumber', 'roomnumber', 'placearea','adv_id');
                    $data['user_id'] = $user_id;
                    $data['owner_type'] = $own;

                    $adv = $adv->update($data);
                    if ($adv) {
                        if (isset($request->img)){
                            foreach ($request->file('img') as $iamge) {
                                $imagname = $this->storeImages($iamge, 'uploads/adv/');
                                Advimages::create([
                                    'img' => $imagname,
                                    'adv_id' => $adv->id,
                                ]);
                                $adv->update(['has_image'=>1]);
                            }
                        }else{
                            $adv->update(['has_image'=>-1,]);
                        }

                    }
                    if (app()->getLocale() == 'ar') {
                        return $this->returnSuccessMessage('تم التحديث بنجاح');
                    } else {
                        return $this->returnSuccessMessage('updated Successfully');
                    }
                }


            } elseif ($type == 1) {

                $rules = [
                    'title' => 'required',
                    'phone' => 'required',
                    'about' => 'required',
                    //    'img' => 'required',
                    'cat_id' => 'required',
                    //  'sub_id' => 'required',
                    'lat' => 'required',
                    'long' => 'required',
                    'address' => 'required',
                    'price' => 'required',
                    'advertismet_type' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',
                    'realstattype_id' => 'required',
                    'realstatepurpose' => 'required',
                    'roomnumber' => 'required',
                    'tolietnumber' => 'required',
                    'placearea' => 'required',
                ];
                $valdaitor = Validator::make($request->all(), $rules);
                if ($valdaitor->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdaitor);
                    return $this->returnValidationError($code, $valdaitor);
                } else {
                    $owner_type=DB::table('app_users')->where('id','=',$user_id)->value('type');
                    if ($owner_type==0){
                        $own=1;
                    }else{
                        $own=2;
                    }
                    $data = $request->only(['title', 'phone', 'about', 'cat_id', 'sub_id', 'lat', 'long', 'address', 'price', 'advertismet_type', 'city_id', 'area_id', 'realstattype_id', 'realstatepurpose', 'tolietnumber', 'placearea','type']);
                    $data['user_id'] = $user_id;
                    $data['owner_type'] = $own;
                    $adv = $adv->update($data);
                    if ($adv) {
                        if (isset($request->img)){
                            foreach ($request->file('img') as $iamge) {
                                $imagname = $this->storeImages($iamge, 'uploads/adv/');
                                Advimages::create([
                                    'img' => $imagname,
                                    'adv_id' => $adv->id,
                                ]);
                            }
                            $adv->update(['has_image'=>1]);
                        }else{
                            $adv->update(['has_image'=>-1,]);
                        }
                        
                           if (isset($request->realstatperiod_id)){
                            $adv->realstatperiod_id=$request->realstatperiod_id;
                            $adv->save;
                        }

                    }
                    if (app()->getLocale() == 'ar') {
                        return $this->returnSuccessMessage('تم التحديث بنجاح');
                    } else {
                        return $this->returnSuccessMessage('updated Successfully');
                    }
                }
            } else {


                $rules = [
                    'title' => 'required',
                    'phone' => 'required',
                    'about' => 'required',
                    //   'img' => 'required',
                    'cat_id' => 'required',
                    //  'sub_id' => 'required',
                    'lat' => 'required',
                    'long' => 'required',
                    'address' => 'required',
                    'price' => 'required',
                    'advertismet_type' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',

                ];
                $valdaitor = Validator::make($request->all(), $rules);
                if ($valdaitor->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdaitor);
                    return $this->returnValidationError($code, $valdaitor);
                } else {
                    $owner_type=DB::table('app_users')->where('id','=',$user_id)->value('type');
                    if ($owner_type==0){
                        $own=1;
                    }else{
                        $own=2;
                    }
                    $data = $request->only(['title', 'phone', 'about', 'cat_id', 'sub_id', 'lat', 'long', 'address', 'price', 'advertismet_type', 'city_id', 'area_id','type']);
                    $data['user_id'] = $user_id;
                    $data['owner_type'] = $own;
                    $adv = $adv->update($data);
                    if ($adv) {
                        if (isset($request->img)){
                            foreach ($request->file('img') as $iamge) {
                                $imagname = $this->storeImages($iamge, 'uploads/adv/');
                                Advimages::create([
                                    'img' => $imagname,
                                    'adv_id' => $adv->id,
                                ]);
                            }
                            $adv->update(['has_image'=>1]);
                        }else{
                            $adv->update(['has_image'=>-1,]);
                        }
                    }
                    if (app()->getLocale() == 'ar') {
                        return $this->returnSuccessMessage('تم التحديث بنجاح');
                    } else {
                        return $this->returnSuccessMessage('updated Successfully');
                    }
                }
            }
        }
    }

    public function addImages(Request $request){
          $rules=[
              'adv_id'          =>         'required',
              'imgs'            =>         'required',
          ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $imagesnames=[];
            foreach ($request->file('imgs') as $single) {
                $imgname = $this->storeImages($single, 'uploads/adv/');
                $imges = new Advimages();
                $imges->img = $imgname;
                $imges->adv_id = $request->adv_id;
                $imges->save();
                array_push($imagesnames,$imges);
            }
            $imagecollescts=collect($imagesnames);
            $resource=updateimagesResponse::collection($imagecollescts);
            return $this->returnData('date',$resource);

        }


    }


    public function deleteimage(Request $request){
        $rules=[
            'img_id'          =>         'required',
        ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
             $image=Advimages::destroy($request->img_id);
              if ($image){
                  if (app()->getLocale()=='ar'){
                      return $this->returnSuccessMessage('تم الحذف بنجاح');
                  }else{
                      return $this->returnSuccessMessage('Deleted Successfully');
                  }
              }

        }
    }


    public function deleteadv(Request $request){

            $destroy=Advertisments::destroy($request->header('adv_id'));
            if ($destroy){
                if (app()->getLocale()=='ar'){
                    return $this->returnSuccessMessage('تم الحذف بنجاح');
                }else{
                    return $this->returnSuccessMessage('Deleted Successfully');
                }
            }
        }


    public function banadv(Request $request){

        $rules = [
            'adv_id' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $user_id =$this->getUserID($request->bearerToken());
            $parma = ['user_id' =>$user_id, 'adv_id' => $request->adv_id];
            $query =Banadv::updateOrCreate($parma, ['status' => 1]);
            if ($query) {
                if (app()->getLocale() == 'ar') {
                    return $this->returnSuccessMessage('تم الحظر بنجاح');
                } else {
                    return $this->returnSuccessMessage('Baned Successfully');
                }
            }
        }

    }

    public function addtoremovefav(Request $request){
        $user_id =$this->getUserID($request->bearerToken());
        $rules = [
            'adv_id' => 'required',
            'status' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {

            $parma = ['user_id' => $user_id, 'adv_id' => $request->adv_id];
            $query = Favoritesadv::updateOrCreate($parma, ['status' => $request->status]);
            if ($query) {
                if (app()->getLocale() == 'ar') {
                    return $this->returnSuccessMessage('تم الحفظ بنجاح');
                } else {
                    return $this->returnSuccessMessage('Saved Successfully');
                }
            }
        }
    }

    public function singleAdv(Request $request){

        $rules = [
            'adv_id' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $id=$this->getUserID($request->bearerToken());
            $single=Advertisments::find($request->adv_id);
            $single->check_id=$id;
            $resource=new singleAdvResource($single);
            return $this->returnData('data',$resource);
        }

    }

    public function search(Request $request){

        $rules = [
            'keyword' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {

            $adv= Advertisments::where('title', 'like', "%$request->keyword%")->latest()->get();
            $recomended=alladvertismetsResource::collection($adv);
            return $this->returnData('data',$recomended);
        }
    }

}
