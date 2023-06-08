@extends('layouts.front')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5 col-side my-5">
                <ul class="list-unstyled list-prod px-3">
                    <h3 class="py-3 text-center">@lang('site.Choose Type')</h3>
                    <form action="">
                        <li class="my-2 py-2 li-color">
                            <a href="{{route('addindex',1)}}">@lang('site.Cars')</a>
                        </li>

                        <li class="my-2 py-2 li-color">
                            <a href="{{route('addindex',2)}}">@lang('site.Buildings')</a>
                        </li>
                        @foreach(collect($dynamic['maincat']) as $single)
                            <li class="my-2 py-2 li-color">
                                <a href="{{route('addindex',$single['id'])}}">{{$single['name']}}</a>
                            </li>
                        @endforeach
                    </form>
                </ul>
            </div>
            <div class="col-lg-9 col-md-7 px-4">
                <form method="post" action="{{route('storeadv')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('post')}}
                    @include('partials._errors')
                   <input type="hidden" name="type" value="0">
                   <input type="hidden" name="cat_id" value="1">
                   <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">

                    <div class="ad-sec add-img my-5">
                        <p class="py-3 px-2"><i class="fas fa-image fa-lg"></i>@lang('site.Add Image')<span class="mx-2">(@lang('site.Max 10 Images'))</span></p>
                        <input type="file" name="img[]" id="" multiple required>
                    </div>

                    <div class="ad-sec add-address my-4">
                        <p class="py-3 px-2">@lang('site.Enter Address')</p>
                        <i class="fas fa-pen "></i><input class="p-2" type="text" name="title" id="" value="{{old('title')}}" placeholder="@lang('site.Enter Address')">
                    </div>
                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Enter Description')</p>
                        <i class="fas fa-book"></i>
                        <input name="about" type="text" class="p-2" value="{{old('about')}}" placeholder="@lang('site.Enter Description')">
                    </div>
                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Enter Price')</p>
                        <i class="fas fa-comment-dollar"></i>
                        <input type="text" name="price" class="p-2" value="{{old('price')}}"  placeholder="@lang('site.Enter Price')" >
                    </div>
                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Choose SubCategory')</p>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2 ">
                            <select name="sub_id"   class="p-2">
                              <option value="sdsa">@lang('site.Choose SubCategory')</option>
                                @foreach(collect($dynamic['catgoreies']) as $single)
                                <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                    </div>
                    <div class="ad-sec add-desc my-4 row">
                        <p class="py-3 px-2">@lang('site.Car Descriptions')</p>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2 ">
                            <i class="fas fa-circle"></i>
                            <select name="brand_id" id="cars" class="p-2 brandsa">
                                   <option value="model">@lang('site.Brands')</option>
                              @foreach(collect($dynamic['brands']) as $single)
                                    <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="model_id" id="mod" class="p-2 " >
                                <option value="model_id">@lang('site.Model')</option>
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="year" id="cars" class="p-2">
                                <option value="year-made">@lang('site.Year')</option>
                                @for($i=1900;$i<=2050;$i++)
                                      <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="status_id" id="cars" class="p-2">
                                <option value="Status">@lang('site.Status')</option>
                               @foreach(collect($dynamic['carStatus']) as $single)
                                    <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="color_id" id="cars" class="p-2">
                                <option value="Colour">@lang('site.color')</option>
                               @foreach(collect($dynamic['Carcolors']) as $single)
                                    <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="shape_id" id="car" class="p-2">
                                <option value="body-type">@lang('site.Body Type')</option>
                                 @foreach(collect($dynamic['Carshapes']) as $single)
                                    <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="door_number" id="cars" class="p-2">
                                <option value="doors">@lang('site.Doors')</option>
                               @foreach(collect($dynamic['carDoors']) as $single)
                                    <option value="{{$single['id']}}">{{$single['number']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="seat_number" id="cars" class="p-2">
                                <option value="seat_number">@lang('site.chairs')</option>
                                  @foreach(collect($dynamic['Carseats']) as $single)
                                    <option value="{{$single['id']}}">{{$single['number']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                            <i class="fas fa-circle"></i>
                            <select name="fueltype_id" id="cars" class="p-2">
                                <option value="oil-type">@lang('site.Oil Type')</option>
                                  @foreach(collect($dynamic['Carfules']) as $single)
                                    <option value="{{$single['id']}}">{{$single['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                          <i class="fas fa-circle"></i>
                          <select name="cartransmissions_id" id="cars" class="p-2">
                              <option value="transmission">@lang('site.Transmission Type') </option>
                                 @foreach(collect($dynamic['Cartransmission']) as $single)
                                  <option value="{{$single['id']}}">{{$single['name']}}</option>
                              @endforeach
                          </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                        <i class="fas fa-circle"></i>
                        <select name="whealsystemtype" id="cars" class="p-2">
                            <option value="propulsion">@lang('site.WealSystem Type')</option>
                             @foreach(collect($dynamic['Cartransmission']) as $single)
                                <option value="{{$single['id']}}">{{$single['name']}}</option>
                            @endforeach
                        </select>
                        </span>
                        <span class="span-select col-xl-2 col-lg-3 col-md-4 m-2">
                          <i class="fas fa-circle"></i>
                          <select name="carenginetype_id" id="cars" class="p-2">
                              <option value="engine">@lang('site.Engine Type')</option>
                               @foreach(collect($dynamic['Carenginetype']) as $single)
                                  <option value="{{$single['id']}}">{{$single['name']}}</option>
                              @endforeach
                          </select>
                        </span>
                    </div>
                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Choose Ad Type')</p>
                        <i class="fas fa-th-large"></i>
                        <select name="advertismet_type" id="" style="width: 80%;" class="p-2">
                            <option value="ad-type">@lang('site.Choose Ad Type')</option>
                            <option value="0">@lang('site.for Sale')</option>
                            <option value="1">@lang('site.needed')</option>
                        </select>
                    </div>
                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Killometers')</p>

                        <input required class="p-2"   name="kilometers" id="" value="{{old('kilometers')}}" placeholder="@lang('site.Killometers')">
                    </div>

                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Choose Ad Place')</p>

                       @if(isset($city))
                         <i class="fas fa-map-marker-alt fa-lg"></i>
                         <select name="city_id" id="" style="width: 20%;" class="p-2 select2">
                            <option value="city">@lang('site.City')</option>
                            @foreach($city as $cite)
                             <option value="{{$cite['id']}}">@if(app()->getLocale()=='ar'){{$cite['name_ar']}}@else{{$cite['name_en']}}@endif</option>
                             @endforeach
                        </select>
                        @endif


                            <select name="area_id" id="arrn" style="width: 20%;" class="p-2">
                                <option value="city">@lang('site.Area')</option>
                            </select>


                    </div>


                    <div class="ad-sec add-desc my-4">
                        <label  class="p-2" for="address">@lang('site.address')</label>
                        <input type="text" id="address-input" name="address" value="{{old('address')}}" placeholder="@lang('site.Enter Address')" class="map-input" required>
                        <input type="hidden" name="lat" id="address-latitude" value="0" />
                        <input type="hidden" name="long" id="address-longitude" value="0" />
                    </div>

                    <div id="address-map-container" style="width:100%;height:400px; ">
                        <div style="width: 100%; height: 100%" id="address-map"></div>
                    </div>

                    <div class="ad-sec add-desc my-4">
                        <p class="py-3 px-2">@lang('site.Enter Mobile')</p>
                        <i class="fas fa-phone-alt"></i>
                        <input required class="p-2"  name="phone" id="" value="{{old('phone')}}"  placeholder="@lang('site.Enter Mobile')">
                    </div>
                    <div class="ad-sec submit-div my-4" >
                        <input class="p-2" type="submit" name="" id="" value="@lang('site.Add')">
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection

