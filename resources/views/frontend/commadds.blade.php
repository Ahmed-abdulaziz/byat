@extends('layouts.front')
@section('content')

    <div class=" mt-5  recommend container">
        <div class="row justify-content-between">
            <div class="row justify-content-center m-auto ">
                <div class="col-xl-3 col-lg-4 col-12  my-3 col-aside">
                    <ul class="list-unstyled list-prod px-3">
                        <li class="py-3">
{{--                            <h3 class="py-3">{{$thiscatC['name']}}</h3>--}}
                            <form action="">
                                <div class="collapse show" id="getting-started-collapse" >
                                    <ul class="list-unstyled fw-normal pb-1 small">
                                        <li class="my-2">
                                            <a href="{{route('commericaldds')}}" class="d-inline-flex align-items-center rounded">@lang('site.All')</a>
                                        </li>
                                        @foreach(collect($resourcect) as $single)
                                        <li class="my-2">
                                            <a href="{{route('getcommericaldds',$single['id'])}}" class="d-inline-flex align-items-center rounded col-10">{{$single['name']}} </a>
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
                                <a href="" class="abtn"  data-img="{{$single['img']}}" data-phone="{{$single['phone']}}" data-whatsapp="{{$single['whatsapp']}}"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <div style="position: relative;">
                                        <img src="{{$single['img']}}" style="width: 26rem; height: 18rem"  class="card-img-top" alt="add-later-image">
                                    </div>
                                </a>
{{--                                    <div class="card-body p-1">--}}
{{--                                        <h5 class="card-title m-0 py-2">{{$single['about']}}</h5>--}}
{{--                                        <span class="date py-2">{{$single['created_at']}}</span>--}}
{{--                                        <div class="row py-2">--}}
{{--                                            <div class="col-8"><h6>{{$single['price']}}</h6></div>--}}
{{--                                            @if($single['favourite']==0)--}}
{{--                                                <a href="{{route('addRemoveFav',$single['id'])}}" class="have-icon">--}}
{{--                                                    <i class="fas fa-heart  fa-lg"></i>--}}
{{--                                                </a>--}}
{{--                                            @else--}}
{{--                                                <a href="{{route('addRemoveFav',$single['id'])}}" class="have-icon active">--}}
{{--                                                    <i class="fas fa-heart  fa-lg"></i>--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Button trigger modal -->


            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="card" id="cardxx">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('site.Close')</button>

                        </div>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>

       $(document).ready(function (){

            $('.abtn').on('click',function (e){
                e.preventDefault();
                var img=$(this).data('img');
                var whatsapp=$(this).data('whatsapp');
                var phone=$(this).data('phone');
                var url = '{{ URL::asset('/uploads/commadds/') }}'
             var html=`<img class="card-img-top" src='${img}' alt="Card image cap">
                                <div class="card-body">
                                    <div class="row">
                          <div class="col-6"> <h2><a class="d-block" href="https://api.whatsapp.com/send?phone=${whatsapp}"> <i class="fab fa-whatsapp" style="color:#60A917;!important;"></i> </a></h2></div>
                          <div class="col-6"><h2 class="d-block">${phone} <i class="fa fa-phone-square-alt" style="color: #0a53be;!important;"></i> </h2></div>

                                        </div>
                                </div>`;
                $('#cardxx').empty();
               $('#cardxx').append(html);

            })
       });

    </script>
@endsection
