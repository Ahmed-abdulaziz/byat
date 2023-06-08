<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg" href="{{asset('frontend/images/logo.svg')}}" />
    <meta name="description" content="Advertising web site" />
    <link rel="apple-touch-icon" href="{{asset('frontend/images/logo.svg')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>souqreem</title>
    @if(app()->getLocale()=='ar')
        <link rel="stylesheet" href="{{asset('frontend/css/style-ar.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    @endif


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
            <form method="post" action="{{'newuser'}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('post')}}
                @include('partials._errors')
                <div class="form-group input-group mb-2">
                    <input name="name" class="form-control" placeholder="@lang('site.Full name')" type="text" required>
                </div> <!-- form-group// -->
                <div class="form-group input-group mb-2">

                    <input name="phone" class="form-control " placeholder="@lang('site.Phone')" type="text" required>
                </div> <!-- form-group// -->
                <div class="form-group input-group mb-2">
                    <input name="email" class="form-control" placeholder="@lang('site.Enter Your email')" type="email">
                </div> <!-- form-group// -->
                <div class="form-group input-group mb-2">
                    <input class="form-control" name="password" placeholder="@lang('site.Password')" type="password">
                </div> <!-- form- mb-2// -->
{{--                <div class="form-group input-group mb-2">--}}
{{--                    <select class=" " name="type">--}}
{{--                        <option selected>@lang('site.Account Type')</option>--}}
{{--                        <option value="0">@lang('site.Personal')</option>--}}
{{--                        <option value="1">@lang('site.Business')</option>--}}
{{--                    </select>--}}
{{--                </div> <!-- form-group end.// -->--}}
                <div class="form-group input-group mb-2">
                            <span style="width: 8%; " class="profile-image">
                                <img src="{{asset('frontend/images/profile-image.png')}}" class="w-100" alt="profile-image">
                            </span>
                    <input name="img" class="form-control " type="file" >
                </div> <!-- form-group// -->
                <div class="form-group policy-check my-3">
                    <input type="checkbox" name="vehicle2" value="Car" style="width: 50px;">
                    <label for="vehicle2">@lang('site.Agree to the Terms of Usage Policy.')</label>
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block Sign-btn  w-100" >@lang('site.Sign up')</button>
                </div> <!-- form-group// -->

            </form>
            <p class="divider-text">
                <span class="bg-light">OR</span>
            </p>

            <p class="text-center ">@lang('site.Have an account ?') <a href="{{route('dashboard.login')}}">@lang('site.Log In')</a> </p>
        </article>
    </div> <!-- card.// -->
    <div class="footer_sign">
        <ul class="list-unstyled d-flex justify-content-center mt-5">
            <li class="px-4"><a href="{{route('usingpolicy')}}">@lang('site.Usage Policy')</a></li>
            <li class="px-4"><a href="{{route('aboutapp')}}">@lang('site.About Us')</a></li>
            <li class="px-4"><a href="{{route('callus')}}">@lang('site.Contact Us')</a></li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
