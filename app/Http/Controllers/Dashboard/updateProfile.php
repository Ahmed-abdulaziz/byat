<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class updateProfile extends Controller
{

    public function index()
    {

    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(User $user)
    {
        //
    }


    public function edit($user)
    {
         abort_if(!auth()->user()->hasPermission('Edit_Profile'), 403);
         
        $user=User::find(auth()->user()->id);
        return view('dashboard.adminedite.edit',compact('user'));
    }


    public function update(Request $request,$user)
    {
         abort_if(!auth()->user()->hasPermission('Edit_Profile'), 403);
         
        $request->validate([
            'first_name'         =>       'required',
            'last_name'          =>       'required',
            'email'              =>       'required',
            'image'              =>       'required',
            'password'           =>       'required',
        ]);

        $date=$request->except('_token','password');
        $date['password']=bcrypt($request->password);
        $appuser=User::find(auth()->user()->id);
        $appuser->update($date);
        Auth::logout();
        return redirect('/login');

    }


    public function destroy(User $user)
    {
        //
    }
}
