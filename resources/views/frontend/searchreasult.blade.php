@extends('layouts.front')
@section('content')
    <div class=" mt-5  recommend container">
        <div class="row m-auto py-3" >
            <div class="row m-auto ">
                <h2 class="col-8 text-left my-5  px-3 ">@lang('site.Search Results')</h2>
            </div>

            @foreach($all as $key=>$singlepro)
                <div class="col-md-6 col-xl-3 col-lg-4 col-12  p-0 ">
                    <div class="m-3 card">
                        <a href="{{route('singleadv',$singlepro['id'])}}">
                            <img src="{{$singlepro['img']}}" style="width: 22rem; height: 18rem" class="card-img-top" alt="add-later-image">
                            <div class="card-body p-1">
                                <h5 class="card-title m-0 py-2">{{$singlepro['about']}}</h5>
                                <span class="date py-2">{{$singlepro['created_at']}}</span>
                                <div class="row py-2">
                                    <div class="col-8"><h6>{{$singlepro['price']}} </h6></div>
                                    <div class="col-4 text-right"><i class="far fa-heart icon fa-lg"></i></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
