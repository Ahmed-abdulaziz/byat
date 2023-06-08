@extends('layouts.front')
@section('slider')
    <div class=" slider container">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"></li>
            </ol>
            <div class="carousel-inner">
               @foreach(collect($data['banars']) as $key=>$banar)
                    <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                    <img src="{{asset('uploads/banars/'.$banar['img'])}}" class="d-block w-100" alt="slider-image">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div>

@endsection
@section('content')
    <!-- categories -->
    <div class=" categories-sec container" id="cat-sec">
        <div class="row  m-auto">
            <h2 class="col-8  my-5  px-3 category-header" >@lang('site.Categories')</h2>
            <a href="{{route('allcat')}}" class="category-link col-4  my-5">@lang('site.View All')<i class="fas fa-chevron-right icon"></i></a>
        </div>
        <div class="row m-0">
            <!-- <div class="cat-item col-4 col-md-2  col-xl-1   py-3">
              <div>
                <a href="#" >
                  <img src="images/img-1.png" alt="cate-car" class="cat-img">
                  <h5 class="cat-title">Cars</h5>
                </a>
              </div>
            </div>
            <div class="cat-item col-4 col-md-2  col-xl-1   py-3">
              <div>
                <a href="#" >
                  <img src="images/img-2.png" alt="cate-car" class="cat-img">
                  <h5 class="cat-title">Electroncs</h5>
                </a>
            </div>
            </div>
            <div class="cat-item col-4 col-md-2  col-xl-1   py-3">
                <div>
                  <a href="#" >
                    <img src="images/img-3.png" alt="cate-car" class="cat-img">
                    <h5 class="cat-title">Devices</h5>
                  </a>
                </div>
            </div>
            <div class="cat-item col-4 col-md-2  col-xl-1   py-3">
                <div>
                  <a href="#" >
                    <img src="images/img-4.png" alt="cate-car" class="cat-img">
                    <h5 class="cat-title">Mobile</h5>
                  </a>
                </div>
            </div>

            <div class="cat-item col-4 col-md-2  col-xl-1   py-3">
                <div>
                  <a href="#" >
                    <img src="images/img-5.png" alt="cate-car" class="cat-img">
                    <h5 class="cat-title">Furniture</h5>
                  </a>
                </div>
            </div>
            <div class="cat-item col-4 col-md-2  col-xl-1   py-3">
                <div>
                  <a href="#" >
                    <img src="images/img-5.png" alt="cate-car" class="cat-img">
                    <h5 class="cat-title">Furniture</h5>
                  </a>

                </div>
            </div> -->
           @foreach(collect($data['categories']) as $object)
                <div class="cat-item col-2    py-3">
                    <div>
                        <a href="{{route('getcat',$object['id'])}}" >
                            <img src="{{$object['img']}}" style="width: 15rem; height: 15rem" alt="cate-car" class="cat-img">
                            <h5 class="cat-title py-2">{{$object['name']}}</h5>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- end categories -->
    <!-- advertsment slider -->
    <div class=" my-2 container">
        <h2 class=" my-5  px-3">@lang('site.Special Ads')</h2>
        <div class=" ads-slider">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach(collect($data['recommended']) as $key=>$singlepro)
                    <div class="carousel-item active">
                        <a href="{{route('singleadv',$singlepro['id'])}}">
                            <img src="{{$singlepro['img']}}" class="d-block w-100 ads-img" alt="ads">
                            <span class="recommend-icon"><i class="fas fa-star"></i></span>
                        </a>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!--
    <ol class="carousel-indicators">
      <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
      <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
    </ol> -->


    <!-- end advertsment -->
    <!-- Add Later -->
    <div class=" mt-5  recommend container">
        <div class="row justify-content-between">
            <div class="row m-auto ">
                <h2 class="col-8 category-header my-5  px-3 ">@lang('site.Add Later')</h2>
                <a href="{{route('alladdlater')}}" class="col-4 category-link my-5">@lang('site.View All')<i class="fas fa-chevron-right icon"></i></a>
            </div>
            <div class="row justify-content-center m-auto ">
            @foreach(collect($data['latest']) as $key=>$singlepro)
                <div class="col-md-6 col-xl-3 col-lg-4 col-12  p-0 ">
                    <div class="m-3 card">
                        <a href="{{route('singleadv',$singlepro['id'])}}">
                            <img src="{{$singlepro['img']}}" style="width: 26rem; height: 18rem" class="card-img-top" alt="add-later-image">
                        </a>
                            <div class="card-body p-1">
                                <h5 class="card-title m-0 py-2">{{$singlepro['about']}}</h5>
                                <span class="date py-2">{{$singlepro['created_at']}}</span>
                                <div class="row py-2">
                                    <div class="col-8"><h6>{{$singlepro['price']}}</h6></div>
                                    <div class="col-4 text-right">
                                    @if($singlepro['favourite']==0)
                                        <a href="{{route('addRemoveFav',$singlepro['id'])}}" class="have-icon">
                                            <i class="fas fa-heart  fa-lg"></i>
                                        </a>
                                        @else
                                            <a href="{{route('addRemoveFav',$singlepro['id'])}}" class="have-icon active">
                                                <i class="fas fa-heart  fa-lg"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <!--End Add Later -->
    <!-- Brands -->
    <section class="py-5 car-brands">
        <div class="container">
            <div class="row justify-content-between my-5" style="position: relative;">
                <div class="col-9">
                    <h2 class=" my-5 px-3">@lang('site.Cars Brands')
                        <span class="under-line"></span>
                    </h2>
                </div>
                <!-- <div class="col-3 col-buttons">
                  <button class="btn-slider slid-right "  type="button" data-bs-target="#carouselExampleDark"  data-bs-slide="prev">
                    <span aria-hidden="true">
                      <i class="fas fa-chevron-left"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="btn-slider slid-left " type="button" data-bs-target="#carouselExampleDark"  data-bs-slide="next">
                    <span aria-hidden="true">
                      <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div> -->
            </div>
            <div class="autoplaySlider">
                @foreach($carbrands as $brand)
                <div>
                    <div class="brand-item">
                        <a href="{{route('allbrandadv',$brand['id'])}}">
                            <img src="{{$brand['img']}}" style="height: 8rem;width: 8rem;" class="brand-img" alt="brand-image">
                            <p class="brand-title text-center">{{$brand['name']}}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- end Brands -->
    <!-- e3lan for client -->
    @if(isset($goads))
    <div class="ad-client">
        <h3 class="text-center py-5">Sidebar</h3>
    </div>
    @endif
    <!--  -->
@endsection
