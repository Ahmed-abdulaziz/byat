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
                                    <th scope="row">@lang('site.phone')</th>
                                    <td colspan="2">{{$singlea['phone']}}</td>
                                    <th scope="row">@lang('site.address')</th>
                                    <td colspan="2">{{$singlea['advertismet_type']}}</td>
                                    <th scope="row">@lang('site.Ad Type')</th>
                                    @if($singlea['advertismet_type']==1)
                                        <td colspan="2">@lang('site.for sale')</td>
                                    @else
                                        <td colspan="2">@lang('site.needed')</td>
                                    @endif
                                </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>



                </div>
            </div>
        </div>

        <h4 class="py-3"><i class="fas fa-map-marker-alt fa-xl " style="color: #373373;"></i> {{$singlea['cityname']}}, {{$singlea['areaname']}}</h4>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d221267.56882737254!2d30.74213966214521!3d29.94188251956089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145855e126df199d%3A0x24a6cf9d2fda5678!2s6th%20of%20October%20City%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1600343903340!5m2!1sen!2seg" width="100%" height="300" title="location" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>



    </div>
@endsection
