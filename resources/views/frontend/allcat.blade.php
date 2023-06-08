@extends('layouts.front')
@section('content')
    <div class=" categories-sec container" id="cat-sec">

        <h2 class="col-8  my-5 category-header  px-3" >@lang('site.Categories')</h2>

        <div class="row m-0">
            @foreach(collect($xyzx['categoriesall']) as $single)
            <div class="cat-item col-6 col-md-4 col-lg-3 col-xl-2   py-3">
                <div>
                    <a href="{{route('getcat',$single['id'])}}" >
                        <img src="{{$single['img']}}" style="width: 12rem; height: 12rem" alt="cate-car" class="cat-img">
                        <h5 class="cat-title py-2">{{$single['name']}}</h5>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
@endsection
