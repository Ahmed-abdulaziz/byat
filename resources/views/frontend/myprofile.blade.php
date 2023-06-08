@extends('layouts.front')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-3 col-side account_iformation my-3 py-4">
                <div class="profile_information_header d-flex justify-content-around align-items-center">
                    <img src="{{asset('uploads/user_images/'.\Illuminate\Support\Facades\Auth::user()->img)}}" class="" width="40%">
                    <div class="profile_information_text">
                        <h3>@lang('site.User Name')</h3>
                        <p>{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
                    </div>
                </div>
                <div class="profile_list mt-4">
                    <div class="profile_list_item my-4 d-flex justify-content-start align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center shopping"><i class="fa fa-shopping-bag fa-2x mx-3"></i></div>
                        <p class="m-0"><a href="{{route('myads')}}">@lang('site.My Ads')</a></p>
                    </div>
                    <hr class="m-2">
                    <div class="profile_list_item my-4 d-flex justify-content-start align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center shopping"><i class="fas fa-heart fa-2x mx-3"></i></div>
                        <p class="m-0"><a href="{{route('myfav')}}">@lang('site.Favorate')</a></p>
                    </div>
                    <hr class="m-2">
                    <div class="profile_list_item my-4 d-flex justify-content-start align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center shopping"><i class="fas fa-sign-out-alt fa-2x mx-3"></i></div>
                        <p class="m-0"><a href="{{route('sigout')}}">@lang('site.Sign Out')</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-9 edit_profile my-3">
                <form class="mx-3" method="post" action="{{route('userUpdateProfile')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('post')}}
                    @include('partials._errors')
                    <div class="form-group my-3">
                        <label class="input-name p-2 px-3" for="name">@lang('site.Name')</label>
                        <input type="text" name="name" class="form-control" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                    </div>

                    <input type="hidden" name="user_id" class="form-control" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                    <div class="form-group my-3">
                        <label class="input-name p-2 px-3" for="phone">@lang('site.Mobile')</label>
                        <input type="text" name="phone" class="form-control" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}">
                    </div>
                    <div class="form-group my-3">
                        <label class="input-name p-2 px-3" for="mail">@lang('site.Email')</label>
                        <input type="text" name="email" class="form-control" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                    </div>
                    <div class="form-group my-3">
                        <label class="input-name p-2 px-3" for="password">@lang('site.Change Password')</label>
                        <input type="password" name="password" class="form-control" placeholder="">
                    </div>
                    <div class="form-group my-3">
                        <label class="input-name p-2 px-3" for="password">@lang('site.Confirm Password')</label>
                        <input type="password" name="password_confirm" class="form-control" placeholder="">
                    </div>
                    <div class="form-group my-3">
                        <label class="input-name p-2 px-3" for="exampleInputEmail1">@lang('site.Change Profile Image')</label>
                        <input type="file" name="img" class="form-control">
                    </div>
                    <div class="d-flex justify-content-end my-5 submit-div">
                        <input type="submit" value="@lang('site.Change')" class="submit py-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
