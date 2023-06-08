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
                    <hr class="m-2">
                    <div class="profile_list_item my-4 d-flex justify-content-start align-items-center">
                        <div class="icon d-flex justify-content-center align-items-center shopping"><i class="fas fa-heart fa-2x mx-3"></i></div>
                        <p class="m-0"><a href="{{route('myfav')}}">@lang('site.Favorate')</a></p>
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
                    <div class="col-md-6  col-lg-4  p-0 ">
                        <div class="card  m-2" style="max-width: 560px;">
                            <div class="row g-0">
                                <div class="col-md-4" style="position: relative;">
                                    <img src="{{$add['img']}}" class="w-100 h-100" alt="...">
                                    <span class="spcial-ad"><i class="fas fa-star fa-lg"></i></span>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <a href="product-details.html">
                                            <h5 class="card-title m-0 py-2">{{$add['title']}}</h5>
                                        </a>

                                        <div class="row" >
                                            <p class="card-text col-6"><strong>{{$add['price']}}</strong></p>
                                            <p class="card-text col-6"><small class="text-muted">{{$add['created_at']}}</small></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row m-1 py-3" style="border-top: 1px  solid rgba(0,0,0,.125);">
                                <div class="col-6 text-center" style="border-right: 1px  solid rgba(0,0,0,.125);"><i class="fas fa-pen icon"></i> Edit</div>
                                <div class="col-6 text-center"><i class="fas fa-trash icon"></i>Delete</div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>

        </div>
    </div>
@endsection
