<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\imageTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use App\Permission;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    use imageTrait;


    public function index(Request $request)
    {
        
         abort_if(!auth()->user()->hasPermission('read_users'), 403);
         
         
        $users = User::whereRoleIs('admin')->when($request->search, function ($query) use ($request) {

            return $query->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));

    }//end of index

    public function create()
    {
        abort_if(!auth()->user()->hasPermission('create_users'), 403);
        
        $permissions = Permission::get();
        return view('dashboard.users.create',compact('permissions'));

    }//end of create

    public function store(Request $request)
    {
        abort_if(!auth()->user()->hasPermission('create_users'), 403);
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'required',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1'
        ]);

       
        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);

        if ($request->has('image')) {
            $image=$this->storeImages($request->image,'laytwfk/public/uploads/user_images/');
            $request_data['image']=$image;
        }//end of if


        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');

    }//end of store

    public function edit(User $user)
    {
        abort_if(!auth()->user()->hasPermission('update_users'), 403);
        if($user->hasRole('super_admin') && auth()->user()->id != $user->id){
            abort(403);
        }
       
       
         $permissions = Permission::get();
        return view('dashboard.users.edit', compact('user','permissions'));

    }//end of user

    public function update(Request $request, User $user)
    {
        
        abort_if(!auth()->user()->hasPermission('update_users'), 403);
        if($user->hasRole('super_admin') && auth()->user()->id != $user->id){
            abort(403);
        }
        
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id),],
            'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['permissions', 'image']);

        if ($request->has('image')) {
            $image=$this->storeImages($request->image,'laytwfk/public/uploads/user_images/');
            $request_data['image']=$image;
        }//end of if

        $user->update($request_data);
        
        DB::table('permission_user')->where('user_id', $user->id)->delete();
        
        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');

    }//end of update

    public function destroy(User $user)
    {
         abort_if(!auth()->user()->hasPermission('delete_users'), 403);
         
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    }//end of destroy

}//end of controller
