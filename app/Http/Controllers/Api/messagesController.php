<?php

namespace App\Http\Controllers\Api;

use App\Models\Messages;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class messagesController extends Controller
{
    use GeneralTrait;
    public function store(Request $request){
        $rules=[
            'name'=>'required',
            'email'=>'required|email',
            'message'=>'required',
            'type'=>'required',
        ];
        $valdator=Validator::make($request->all(),$rules);
        if ($valdator->fails()){
            $code=$this->returnCodeAccordingToInput($valdator);
            return $this->returnValidationError($code,$valdator);
        }else{

            $message=Messages::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'message'=>$request->message,
                'type'=>$request->type,
            ]);
           if ($message){
                if (app()->getLocale()=='ar'){
                    return $this->returnSuccessMessage('شكرا لتواصلك معانا');
                }else{
                    return $this->returnSuccessMessage('Thank You');
                }
           }

        }

    }


}
