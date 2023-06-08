<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg" href="{{asset('frontend/images/fav-ic.png')}}" />

    <link rel="stylesheet" href="{{asset('frontend/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/slick/slick-theme.css')}}">
    <meta name="description" content="Advertising web site" />
    <link rel="apple-touch-icon" href="{{asset('frontend/images/logo.svg')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Souqrim Home Page</title>
    @if(app()->getLocale()=='ar')
        <link rel="stylesheet" href="{{asset('frontend/css/style-ar.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- =========== -->
    <link rel="stylesheet" href="{{asset('frontend/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/slick/slick-theme.css')}}">
    {{--noty--}}
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/noty.css') }}">
    <script src="{{ asset('dashboard/plugins/noty/noty.min.js') }}"></script>

</head>
<body>
<!-- Navbar -->
<header class="">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('frontend/images/logo.png')}}" alt="site-logo" width="125px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse collaps-one" id="navbarSupportedContent">
                    <div class="navbar-collapse collaps-two">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('home')}}"><b>@lang('site.Home')</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-nowrap" href="{{route('aboutapp')}}"><b>@lang('site.About Us')</b></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-nowrap" href="{{route('commericaldds')}}"><b>@lang('site.commercial ads')</b></a>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-nowrap" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b>  @lang('site.Categories')</b>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach(collect($xyzx['categoriesx']) as $object)
                                        <li><a class="dropdown-item" href="{{route('getcat',$object['id'])}}">{{$object['name']}}</a></li>
                                @endforeach
                                </ul>

                            </li>
                            <li class="nav-item text-nowrap">
                                <a class="nav-link " href="{{route('callus')}}" ><b>@lang('site.callus')</b></a>
                            </li>
                        </ul>
                        <form action="{{'search'}}" method="get" class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="@lang('site.Search')" aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit">@lang('site.Search')</button>
                        </form>
                        <div>
                            @if(app()->getLocale()=='ar')
                                <button class="btn-arbic m-0 p-0"><a  href="{{ LaravelLocalization::getLocalizedURL('fr', null, [], true) }}">@lang('site.English')</a></button>
                            @else
                                <button class="btn-arbic"><a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">@lang('site.Arabic')</a></button>|
                            @endif

                            @if(isset(\Illuminate\Support\Facades\Auth::guard('customer')->user()->id))
                                <a href="{{route('profile')}}" class="text-nowrap"><i class="fas fa-user fa-lg" style="color: #16e693;"></i></a>
                                <a href="{{route('sigout')}}" class="sign-in text-nowrap">@lang('site.Sign Out')</a>
                            @else
                                <a href="{{route('dashboard.login')}}" class="sign-in text-nowrap">@lang('site.Sign In')</a>
                            @endif

                        </div>
                     </div>
                </div>
            </div>
        </nav>

    </div>
</header>
