@extends('layouts.front')
@section('content')
    <div class=" mt-5  recommend container">

        <div class="row justify-content-center">

            <ul class="list-unstyled list-prod px-3 row" style="background-color: #e6e3e3;">
                <div class="row">
                    <div class="col-xl-7 col-6 ">
                        <div class="py-2 filter" style="border-radius: 6px;">
                            <h3 class=" text-center m-0">@lang('site.Filter')</h3>
                        </div>
                    </div>
                    <div class="col-6 col-xl-5">
                        <div class="dropdown  w-100 sort-by">
                            <button class=" dropdown-toggle w-100 py-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-stream" style="color: #fff;"></i>  @lang('site.Sort By')
                            </button>
                            <ul class="dropdown-menu px-2 w-100" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" checked value="option1">
                                    <label class="form-check-label sort-by-label" for="inlineRadio1">@lang('site.from oldest to newest')</label>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label sort-by-label" for="inlineRadio1">@lang('site.from newest to newest')</label>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label sort-by-label" for="inlineRadio1">@lang('site.price: from high to low')</label>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label sort-by-label" for="inlineRadio1">@lang('site.price: from low to high')</label>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label sort-by-label" for="inlineRadio1">@lang('site.nearest to farthest')</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="row justify-content-center">

                    <li class="mb-1 py-4   col-lg-4 col-md-6">
                        <h5> <i class="fas fa-bullhorn" style="color: #373373;margin-right: 7px;"></i> @lang('site.Ads type')</h5>
                        <button class="btn-1 btn-all">all</button><button class="btn-1">for sale</button><button class="btn-1 btn-buy">@lang('site.for buy')</button>
                    </li>
                    <li class="mb-1 py-4   col-lg-4 col-md-6">
                        <h5> <i class="fas fa-image fa-x " style="color: #373373;margin-right: 7px;"></i> @lang('site.with image')</h5>
                        <button class="btn-1 btn-all">all</button><button class="btn-1 with-img">with image</button><button class="btn-1 btn-buy">@lang('site.without')</button>
                    </li>
                    <li class="mb-1 py-4  col-lg-4 col-md-6">
                        <h5> <i class="fas fa-user" style="color: #373373; margin-right: 7px;"></i>@lang('site.Ad Owner')</h5>
                        <button class="btn-1 btn-all">all</button><button class="btn-1">@lang('site.Owner')</button><button class="btn-1 btn-buy">@lang('site.business')</button>
                    </li>

                    <li class="mb-1 py-4   col-lg-4 col-md-6">
                        <h5 class="price"> <i class="fas fa-dollar-sign icon-price"></i>@lang('site.Price')</h5>
                        <div class="row">
                            <div class=" col-6 from-to-price"> <span class=" py-2">@lang('site.From') </span><input type="text " class="int-price w-50 " placeholder="00.00"></div>
                            <div class="col-6 from-to-price"> <span class=" py-2">@lang('site.To') </span><input type="text " class="int-price w-50" placeholder="00.00"></div>
                        </div>

                    </li>
                    <li class="mb-1 py-4   col-lg-4 col-md-6">
                        <div class="dropdown ">
                            <button class="  dropdown-toggle btn-city" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-map-marker-alt " style="color: #373373; margin-right: 7px;"></i>  @lang('site.city')
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <li class="py-3 px-2">
                                    <a href="#"><i class="fas fa-search-location fa-lg" style="color: #16e693;"></i>@lang('site.Find location')</a>
                                </li>
                                <li style="background-color: #f4f4f4f4;" class="py-3 px-2">
                                    <p class="m-0 px-2">@lang('site.last used')</p>
                                </li>
                                <li class="py-3 px-2">
                                    <p class="m-0 px-2"><i class="fas fa-history fa-lg" style="color: #ccc;"></i> cairo egypt</p>
                                </li>
                                <li class="py-3 ">
                                    <button class="choose-city d-inline-flex align-items-center  collapsed" data-bs-toggle="collapse" data-bs-target="#choose-city-collapse" aria-expanded="false">
                                        @lang('site.Choose city')
                                    </button>
                                    <div class=" px-2" id="choose-city-collapse">
                                        <ul class="list-unstyled fw-normal pb-1 small p-2">
                                            <li class="py-2">
                                                <input type="radio" id="cairo" name="brand" value="cairo"  checked="checked">
                                                <label for="cairo">cairo</label><br>
                                            </li>
                                            <li  class="py-2">
                                                <input type="radio" id="cairo" name="brand" value="cairo"  >
                                                <label for="cairo">cairo</label><br>
                                            </li>
                                            <li  class="py-2">
                                                <input type="radio" id="cairo" name="brand" value="cairo">
                                                <label for="cairo">cairo</label><br>
                                            </li>
                                            <li  class="py-2">
                                                <input type="radio" id="cairo" name="brand" value="cairo">
                                                <label for="cairo">cairo</label><br>
                                            </li>
                                        </ul>
                                    </div>

                                </li>

                            </ul>
                        </div>
                    </li>
                </div>
                <!-- /////////////// -->
                <div class="row justify-content-center">
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light w-100 ">

                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Brands')
                                </a>

                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="bmw" name="brand" value="bmw">
                                        <label for="bmw">bmw</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="Mercedes" name="brand" value="Mercedes">
                                        <label for="Mercedes">Mercedes</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="ople" name="brand" value="ople">
                                        <label for="ople">ople</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">

                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Model')
                                </a>

                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="checkbox" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="Benz" name="brand" value="Benz"  >
                                        <label for="Benz">Benz</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="verna" name="brand" value="verna">
                                        <label for="verna">verna</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="vagn" name="brand" value="vagn">
                                        <label for="vagn">vagn</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="cooper" name="brand" value="cooper">
                                        <label for="cooper">cooper</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">

                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Year Made')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="checkbox" id="2021" name="brand" value="2021"  checked="checked">
                                        <label for="2021">2021</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="2020" name="brand" value="2020"  >
                                        <label for="2020">2020</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="2019" name="brand" value="2019">
                                        <label for="2019">2019</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="2018" name="brand" value="2018">
                                        <label for="2018">2018</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Status')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="checkbox" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>

                                    <li class="py-2">
                                        <input type="checkbox" id="new" name="brand" value="new">
                                        <label for="new">@lang('site.new')</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" id="Used" name="brand" value="Used">
                                        <label for="Used">@lang('site.Used')</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.color')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> Colour
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">

                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Doors')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="2" name="brand" value="2">
                                        <label for="2">2</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="4" name="brand" value="4">
                                        <label for="4">4</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> Chairs
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li>
                                        <input type="radio" id="2" name="brand" value="2">
                                        <label for="2">2</label><br>
                                    </li>
                                    <li>
                                        <input type="radio" id="4" name="brand" value="4">
                                        <label for="4">4</label><br>
                                    </li>
                                    <li>
                                        <input type="radio" id="6" name="brand" value="6">
                                        <label for="6">6</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> Type of Moving
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Oil Type')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Kilometers')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li>
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">


                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Motor Type')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">

                        <li class="mb-1 py-4 li-light ">
                            <div class="dropdown w-100">
                                <a class="btn btn-secondary dropdown-toggle w-100 btn-color fw-bold" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-circle fa-lg icon-brand"></i> @lang('site.Push Power')
                                </a>
                                <ul class="dropdown-menu w-100 px-2" aria-labelledby="dropdownMenuLink">
                                    <li class="py-2">
                                        <input type="radio" id="all" name="brand" value="all"  checked="checked">
                                        <label for="all">all</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="black" name="brand" value="black">
                                        <label for="black">black</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="red" name="brand" value="red">
                                        <label for="red">red</label><br>
                                    </li>
                                    <li class="py-2">
                                        <input type="radio" id="white" name="brand" value="white">
                                        <label for="white">white</label><br>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>



                </div>
                <!-- <li class="my-5">
                  <input class="" type="submit" id="" value=" Show resualt" >
                </li>  -->
            </ul>

            <div class="row m-auto py-3" >
                <div class="col-md-6 col-xl-3 col-lg-4  p-0 ">
                    <div class="m-3 card">
                        <a href="product-details.html">
                            <img src="images/car0.jpg" class="card-img-top" alt="add-later-image">
                        </a>
                            <div class="card-body p-1">
                                <h5 class="card-title m-0 py-2">Cars Model 2020 ...</h5>
                                <span class="date py-2">22 Oct 2020</span>
                                <div class="row py-2">
                                    <div class="col-8"><h6>000.00EG</h6></div>
                                    <div class="col-4 text-right"><i class="far fa-heart icon fa-2x"></i></div>
                                </div>
                            </div>

                    </div>
                </div>

            </div>
            <nav aria-label="Page navigation example my-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>



        </div>
    </div>
@endsection
