@extends('layouts.front')
@section('content')

    <div class=" mt-5  recommend container">
        <div class="row justify-content-between">
            <div class="row justify-content-center m-auto ">
                <div class="col-xl-3 col-lg-4 col-12  my-3 col-aside">
                    <ul class="list-unstyled list-prod px-3">
                        <li class="py-3">
                            <h3 class="py-3">@lang('site.Buildings')</h3>
                            <form action="">
                                <div class="collapse show" id="getting-started-collapse" >
                                    <ul class="list-unstyled fw-normal pb-1 small">
                                        <li class="my-2">
                                            <a href="#" class="d-inline-flex align-items-center rounded">@lang('site.All')</a>
                                        </li>
                                        @foreach(collect($resourcect) as $single)
                                        <li class="my-2">
                                            <a href="{{route('getsubcat',$single['id'])}}" class="d-inline-flex align-items-center rounded col-10">{{$single['name']}} </a>
                                            <span class="col-2"><i class="fas fa-chevron-right"></i></span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </form>

                        </li>


                    </ul>
                </div>
                <div class="col-xl-9 col-lg-8  col-12">
                    <div class="row m-auto py-3" >
                       @foreach($all as $single)
                        <div class="col-md-6 col-xl-3 col-lg-4 col-12  p-0 ">
                            <div class="m-3 card">
                                <a href="{{route('singleadv',$single['id'])}}">
                                    <div style="position: relative;">
                                        <img src="{{$single['img']}}" style="width: 20rem; height: 10rem" class="card-img-top" alt="add-later-image">
                                        @if($single['special']==1)
                                            <span class="spcial-ad" ><i class="fas fa-star fa-lg"></i></span>
                                        @endif
                                    </div>
                                </a>
                                    <div class="card-body p-1">
                                        <h5 class="card-title m-0 py-2">{{$single['about']}}</h5>
                                        <span class="date py-2">{{$single['created_at']}}</span>
                                        <div class="row py-2">
                                            <div class="col-8"><h6>{{$single['price']}}</h6></div>
                                            @if($single['favourite']==0)
                                                <a href="{{route('addRemoveFav',$single['id'])}}" class="have-icon">
                                                    <i class="fas fa-heart  fa-lg"></i>
                                                </a>
                                            @else
                                                <a href="{{route('addRemoveFav',$single['id'])}}" class="have-icon active">
                                                    <i class="fas fa-heart  fa-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
{{--            <nav aria-label="Page navigation example my-3">--}}
{{--                <ul class="pagination justify-content-center">--}}
{{--                    <li class="page-item">--}}
{{--                        <a class="page-link" href="#" aria-label="Previous">--}}
{{--                            <span aria-hidden="true">&laquo;</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                    <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                    <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                    <li class="page-item">--}}
{{--                        <a class="page-link" href="#" aria-label="Next">--}}
{{--                            <span aria-hidden="true">&raquo;</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </nav>--}}
        </div>
    </div>

@endsection
