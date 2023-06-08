<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\myAdvResource;
use App\Http\Resources\SavedList;
use App\Http\Resources\technicalGalaryimages;
use App\Http\Resources\uploadImageResponse;
use App\Http\Resources\userProfileResource;
use App\Models\appUsers;
use App\Models\CompanyworkDays;
use App\Models\tecniaclGalaryImages;
use App\Models\workdays;
use App\Traits\GeneralTrait;
use App\Traits\Helperfunctions;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class userProfileUpdate extends Controller
{
    use GeneralTrait;
    use imageTrait;
    use Helperfunctions;
    public function updateLangCountry(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'lang' => 'required',
            'Country_id' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            // $id=$this->getID($request->api_token,'app_users');
            $update = DB::table('app_users')->where('id', '=', $request->user_id)->update(['country_id' => $request->Country_id, 'lang' => $request->lang]);
            if (app()->getLocale() == 'ar') {
                return $this->returnSuccessMessage('تم التحديث بنجاح');
            } else {
                return $this->returnSuccessMessage('Updated Successfully');
            }
        }
    }

    public function getProfile(Request $request)
    {
        $rules = [
            'user_id' => 'required',

        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $appuser = appUsers::find($request->user_id);
            $resourse = new userProfileResource($appuser);
            return $this->returnData('user', $resourse);
        }
    }

    public function updatedata(Request $request)
    {
        $rules = [
            'user_id' => 'required'
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $type = DB::table('app_users')->where('id', '=', $request->user_id)->value('type');
            $appUsers = appUsers::find($request->user_id);
            if ($type == 0) {
                $rules = [
                ];
                $valdator = Validator::make($request->all(), $rules);
                if ($valdator->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdator);
                    return $this->returnValidationError($code, $valdator);
                } else {
                    if ($request->has('img')) {
                        $image = $this->storeImages($request->img, 'uploads/user_images/');
                        $appuser = $appUsers->update([
                        ]);
                    } else {
                        $appuser = $appUsers->update([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'active' => 1,
                            'password' => bcrypt($request->password),
                        ]);

                    }
                    $credentioal = $request->only(['email', 'password']);
                    $token = \Illuminate\Support\Facades\Auth::guard('app_users')->attempt($credentioal);
                    if (!$token) {
                        if (app()->getLocale() == 'ar') {
                            return $this->returnError('', 'هناك خطأ بالبينات');
                        } else {
                            return $this->returnError('', 'Phone Number Or Email Error');
                        }

                    } else {
                        $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                        $customer->api_token = $token;
                        $customer->save();
                        $rescus = new userProfileResource($customer);
                        return $this->returnData('user', $rescus);
                    }

                }


            } elseif ($type == 1) {
                $rules = [
                ];
                $valdator = Validator::make($request->all(), $rules);
                if ($valdator->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdator);
                    return $this->returnValidationError($code, $valdator);
                } else {
                    if ($request->has('img')) {
                        $image = $this->storeImages($request->img, 'uploads/user_images/');
                        $appuser = appUsers::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'cat_id' => $request->cat_id,
                            'area_id' => $request->area_id,
                            'brif' => $request->brif,
                            'img' => $image,
                            'type' => 1,
                            'password' => bcrypt($request->password),
                        ]);
                    } else {
                        $appuser = appUsers::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'cat_id' => $request->cat_id,
                            'area_id' => $request->area_id,
                            'brif' => $request->brif,
                            'type' => 1,
                            'password' => bcrypt($request->password),
                        ]);

                    }
                    $credentioal = $request->only(['email', 'password']);
                    $token = \Illuminate\Support\Facades\Auth::guard('app_users')->attempt($credentioal);
                    if (!$token) {
                        if (app()->getLocale() == 'ar') {
                            return $this->returnError('', 'هناك خطأ بالبينات');
                        } else {
                            return $this->returnError('', 'Phone Number Or Email Error');
                        }

                    } else {
                        $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                        $customer->api_token = $token;
                        $customer->save();
                        $rescus = new userProfileResource($customer);
                        return $this->returnData('user', $rescus);
                    }

                }

            } elseif ($type == 2) {

                $rules = [
                ];
                $valdator = Validator::make($request->all(), $rules);
                if ($valdator->fails()) {
                    $code = $this->returnCodeAccordingToInput($valdator);
                    return $this->returnValidationError($code, $valdator);
                } else {
                    if ($request->has('img')) {
                        $image = $this->storeImages($request->img, 'uploads/user_images/');
                        $appuser = $appUsers->update([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'cat_id' => $request->cat_id,
                            'area_id' => $request->area_id,
                            'brif' => $request->brif,
                            'latlong' => $request->latlong,
                            'img' => $image,
                            'type' => 2,
                            'password' => bcrypt($request->password),
                        ]);


                    } else {
                        $appuser = $appUsers->update([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'cat_id' => $request->cat_id,
                            'area_id' => $request->area_id,
                            'latlong' => $request->latlong,
                            'brif' => $request->brif,
                            'type' => 2,
                            'password' => bcrypt($request->password),
                        ]);


                    }
                    $credentioal = $request->only(['email', 'password']);
                    $token = \Illuminate\Support\Facades\Auth::guard('app_users')->attempt($credentioal);
                    if (!$token) {
                        if (app()->getLocale() == 'ar') {
                            return $this->returnError('', 'هناك خطأ بالبينات');
                        } else {
                            return $this->returnError('', 'Phone Number Or Email Error');
                        }
                    } else {
                        $customer = \Illuminate\Support\Facades\Auth::guard('app_users')->user();
                        $customer->api_token = $token;
                        $customer->save();
                        $rescus = new userProfileResource($customer);
                        return $this->returnData('user', $rescus);
                    }
                }
            }
        }
    }

    public function viewGalary(Request $request)
    {
        $rules = [
            'galary_id' => 'required',
        ];

        $valadator = Validator::make($request->all(), $rules);
        if ($valadator->fails()) {
            $code = $this->returnCodeAccordingToInput($valadator);
            $this->returnValidationError($code, $valadator);
        } else {
            $galary = tecniaclGalaryImages::all()->where('galary_id', '=', $request->galary_id);
            $resource=technicalGalaryimages::collection($galary);
            return $this->returnData('galary', $resource);
        }
    }

    public function addimgsToGalary(Request $request)
    {
        $rules = [
            'galary_id' => 'required',
            'imgs' => 'required',
        ];

        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $imagesnames=[];
            foreach ($request->imgs as $img) {
                $images = $this->storeImages($img, 'uploads/tencicalgalray/');
                $img = tecniaclGalaryImages::create([
                    'galary_id' => $request->galary_id,
                    'img' => $images,
                ]);
                array_push($imagesnames,$img);
            }
             $imagecollescts=collect($imagesnames);
             $resource=uploadImageResponse::collection($imagecollescts);
             return $this->returnData('galary',$resource);
        }
    }

    public function deleteimage(Request $request)
    {
        $rules = [
            'img_id' => 'required'
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $img = tecniaclGalaryImages::destroy($request->img_id);
            if (app()->getLocale() == 'ar') {
                return $this->returnSuccessMessage('تم حذف الصوره بنجاح');
            } else {
                return $this->returnSuccessMessage('image Deleted Successfully');
            }
        }

    }

    public function mysaved(Request $request){
        $rules = [
            'user_id' => 'required',
            'type' => 'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
           $user=appUsers::find($request->user_id);
           $user->type=$request->type;
           $resource=new SavedList($user);
           return $this->returnData('data',$resource);
        }

    }
    public function myAdv(Request $request){
        $rules=[
            'user_id'      =>    'required',
        ];
        $valdator = Validator::make($request->all(), $rules);
        if ($valdator->fails()) {
            $code = $this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code, $valdator);
        } else {
            $appuser=appUsers::find($request->user_id);
            $resource=new myAdvResource($appuser);
            return  $this->returnData('data',$resource);
        }

    }


}
