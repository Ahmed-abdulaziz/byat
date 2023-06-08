<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg" href="{{asset('frontend/images/logo.svg')}}" />
    <meta name="description" content="Advertising web site" />
    <link rel="apple-touch-icon" href="{{asset('frontend/images/logo.svg')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>souqreem</title>
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body class="register">
<div class="container my-5 py-5">
    <div class="card bg-light">
        <article class="card-body  m-auto" style="width: 80%;" >
            <div class="card-title mt-3 text-center">
                <img src="{{asset('frontend/images/logo.png')}}" alt="site-logo">
            </div>
            <h4 class="text-center my-3">@lang('site.Sign in to souqreem') </h4>
            <form method="post" action="{{route('validatef')}}">
                {{ csrf_field() }}
                {{ method_field('post') }}

                @include('partials._errors')
                <div class="form-group input-group mb-2">
                    <input name="emailorphone" class="form-control" placeholder="@lang('site.Email or Phone Number')" type="text">
                </div> <!-- form-group// -->
                <div class="form-group input-group mb-2">
                    <input class="form-control" placeholder="@lang('site.Password')" name="password" type="password">
                </div> <!-- form-group// -->
                <div class="text-center">
{{--                    <p> <a href="forgot-password.html" style="color: #373373;">@lang('site.Forgot Password ?')</a></p>--}}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block Sign-btn w-100"> @lang('site.Sign in')</button>
                </div> <!-- form-group// -->
            </form>
            <p class="text-center py-2 mb-5">@lang("site.New to souqreem?") <a href="{{route('signup')}}">@lang('site.Sign in to souqreem')</a> </p>

        </article>
    </div> <!-- card.// -->


    <div class="footer_sign">
        <ul class="list-unstyled d-flex justify-content-center mt-5">
            <li class="px-4"><a href="{{route('usingpolicy')}}">@lang('site.Usage Policy')</a></li>
            <li class="px-4"><a href="{{route('aboutapp')}}">@lang('site.About Us')</a></li>
            <li class="px-4"><a href="{{route('callus')}}">@lang('site.Contact Us')</a></li>
        </ul>
    </div><!--end footersign-->
</div>


<!--end copyright -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
