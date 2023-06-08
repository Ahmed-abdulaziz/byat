@extends('layouts.front')
@section('content')
    <div class="container bulding-details">
        <div class="card my-3" >
            <div class="row g-0">
                <div class="col-md-4">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach(collect($singlea['imgs']) as $img)
                            <div class="carousel-item active">
                                <img src="{{$img['img']}}" alt="Product-details" class="w-100 h-100">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-8">

                    <div class="card-body p-1">
                        <h3 class="card-title m-0 py-2">{{$singlea['title']}}</h3>
                        <p class="description" style="line-height: 1.7;">{{$singlea['about']}}</p>
                        <div class="row p-2">
                            <div class="col-8"><h4>{{$singlea['price']}}</h4></div>
                            <div class="col-4 text-right">{{$singlea['created_at']}}</div>
                        </div>
                        <div class="desc-div py-3">
                            <table class="table table-striped table-hover">

                                <tbody>
                                <tr>
                                    <th scope="row">@lang('site.brand')</th>
                                    <td colspan="2">{{$singlea['branname']}}</td>
                                    <th scope="row">@lang('site.Model')</th>
                                    <td colspan="2">{{$singlea['modelname']}}</td>
                                    <th scope="row">@lang('site.Year')</th>
                                    <td colspan="2">{{$singlea['year']}}</td>
                                </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>



                </div>
            </div>
        </div>

        <h4 class="py-3"><i class="fas fa-map-marker-alt fa-xl " style="color: #373373;"></i> {{$singlea['cityname']}}, {{$singlea['areaname']}}</h4>
    </div>
@endsection
