@extends('layouts.front')
@section('content')
    <div class=" mt-5  recommend container">

        <div class="row justify-content-center">

            @if($type==1)
                     <form method="get" action="{{route('getsubcat',$id)}}">
                         <div class="row justify-content-center">
                             <ul class="list-unstyled list-prod px-3 row" style="background-color: #e6e3e3;">



                         <li class="mb-1 py-4   col-lg-4 col-md-6">
                             <h5>@lang('site.Brands')</h5>
                            <select  name="brand_id" id="cars" class="p-2 brandsa">
                                   <option  style="background-color: #e6e3e3;" value=0>@lang('site.Brands')</option>
                              @foreach(collect($dynamic['brands']) as $single)
                                    <option style="background-color: #e6e3e3;" value="{{$single['id']}}">{{$single['name']}}</option>
                              @endforeach
                            </select>
                        </li>


                       <li class="mb-1 py-4   col-lg-4 col-md-6">
                       <h5>@lang('site.Model')</h5>
                           <select name="model_id" id="mod" class="p-2 " >
                               <option  style="background-color: #e6e3e3;" value=0>@lang('site.Model')</option>
                           </select>
                        </li>


                                 <li class="mb-1 py-4   col-lg-4 col-md-6">
                                     <h5>@lang('site.price_from')</h5>
                                     <input type="number" style="width: 80%;" class="p-2"   name="price_from" id="" value="0" placeholder="@lang('site.price_from')">
                                 </li>

                                 <li class="mb-1 py-4   col-lg-4 col-md-6">
                                     <h5>@lang('site.price_to')</h5>
                                     <input type="number" style="width: 80%;" class="p-2"   name="price_to" id="" value="0" placeholder="@lang('site.price_to')">
                                 </li>


                                 <li class="mb-1 py-4   col-lg-4 col-md-6">
                      <h5>@lang('site.Year')</h5>
                            <select name="year" id="cars" class="p-2">
                                <option  style="background-color: #e6e3e3;" value=0>@lang('site.Year')</option>
                                @for($i=1900;$i<=2050;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                     </li>


                    <div class="ad-sec submit-div">
                        <input class="p-2 w-100" type="submit" name="" id="" value="@lang('site.Show Results')">
                    </div>
                             </ul>
                </div>
                    </form>

            @elseif($type==2)
                <form method="get" action="{{route('getsubcat',$id)}}">

                    <div class="row justify-content-center">
                        <ul class="list-unstyled list-prod px-3 row" style="background-color: #e6e3e3;">


                            <li class="mb-1 py-4   col-lg-4 col-md-6">
                            <h5>@lang('site.Room Number')</h5>
                            <input type="number" style="width: 80%;" class="p-2"   name="roomnumber" id="" value="0" placeholder="@lang('site.Room Number')">
                            </li>

                            <li class="mb-1 py-4   col-lg-4 col-md-6">
                                <h5>@lang('site.placearea')</h5>
                                <input type="number" style="width: 80%;" class="p-2"   name="placearea" id="" value="0" placeholder="@lang('site.placearea')">
                            </li>

                            <li class="mb-1 py-4   col-lg-4 col-md-6">
                                <h5>@lang('site.price_from')</h5>
                                <input type="number" style="width: 80%;" class="p-2"   name="price_from" id="" value="0" placeholder="@lang('site.price_from')">
                            </li>

                            <li class="mb-1 py-4   col-lg-4 col-md-6">
                                <h5>@lang('site.price_to')</h5>
                                <input type="number" style="width: 80%;" class="p-2"   name="price_to" id="" value="0" placeholder="@lang('site.price_from')">
                            </li>



                            <div class="ad-sec submit-div">
                            <input class="p-2 w-100" type="submit" name="" id="" value="@lang('site.Show Results')">
                        </div>
                        </ul>
                    </div>
                </form>

            @else
                <form method="get" action="{{route('getsubcat',$id)}}">
                    <div class="row justify-content-center">
                        <ul class="list-unstyled list-prod px-3 row" style="background-color: #e6e3e3;">
                            <li class="mb-1 py-4   col-lg-4 col-md-6">
                                <h5>@lang('site.price_from')</h5>
                                <input type="number" style="width: 80%;" class="p-2"   name="price_from" id="" value="0" placeholder="@lang('site.price_from')">
                            </li>

                            <li class="mb-1 py-4   col-lg-4 col-md-6">
                                <h5>@lang('site.price_to')</h5>
                                <input type="number" style="width: 80%;" class="p-2"   name="price_to" id="" value="0" placeholder="@lang('site.price_from')">
                            </li>

                            <div class="ad-sec submit-div">
                                <input class="p-2 w-100" type="submit" name="" id="" value="@lang('site.Show Results')">
                            </div>
                        </ul>
                    </div>
                </form>
            @endif





            <div  class="col-xl-9 col-lg-8  col-12">
                <div class="row m-auto py-3" >
                   @if($all->isEmpty())
                        <div style="height: 400px">
                            <h2>@lang('site.no_data_found')</h2>
                        </div>
                    @else
                        @foreach($all as $single)
                            <div class="col-md-6 col-xl-3 col-lg-4 col-12  p-0 ">
                                <div class="m-3 card">
                                    <a href="{{route('singleadv',$single['id'])}}">
                                        <div style="position: relative;">
                                            <img src="{{$single['img']}}" style="width: 20rem; height: 10rem" class="card-img-top" alt="add-later-image">
                                            <span class="spcial-ad" ><i class="fas fa-star fa-lg"></i></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <h5 class="card-title m-0 py-2">{{$single['about']}}</h5>
                                            <span class="date py-2">{{$single['created_at']}}</span>
                                            <div class="row py-2">
                                                <div class="col-8"><h6>{{$single['price']}}</h6></div>
                                                <div class="col-4 text-right"><i class="far fa-heart icon fa-2x"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
