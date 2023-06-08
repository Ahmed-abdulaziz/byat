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
                        <div class="icon d-flex justify-content-center align-items-center shopping"><i class="fas fa-edit fa-2x mx-3"></i></div>
                        <p class="m-0"><a href="{{route('profile')}}">@lang('site.Edit Profile')</a></p>
                    </div>
                    <hr class="m-2">
                    <div class="profile_list_item my-4 d-flex justify-content-start align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center shopping"><i class="fas fa-sign-out-alt fa-2x mx-3"></i></div>
                        <p class="m-0"><a href="{{route('sigout')}}">@lang('site.Sign Out')</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9  col-md-7  edit_profile my-3">
                <div class="row m-auto py-3" >
                    @foreach($ads as $add)
                    <div class="col-md-6 col-xl-3 col-lg-4  p-0">
                        <div class="m-3 card">

                            <img src="{{$add['img']}}" style="width: 50rem; height: 15rem" class="card-img-top" alt="add-later-image">
                            <div class="card-body p-1">
                                <a href="{{route('singleadv',$add['id'])}}">
                                    <h5 class="card-title m-0 py-2">{{$add['about']}}</h5>
                                </a>
                                <span class="date py-2">{{$add['created_at']}}</span>
                                <div class="row py-2 div-icon">
                                    <div class="col-8"><h6>{{$add['price']}}</h6></div>

                                        <a href="{{route('addRemoveFav',[$add['id'],0])}}" class="have-icon active">
                                            <i class="fas fa-heart  fa-lg"></i>
                                        </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>

            </div>

        </div>
    </div>
@endsection
