@extends('layouts.front')
@section('content')
    <div class="about-page">
        <div class="container my-5 about">
            <h2 class="my-5">@lang('site.About Us')</h2>
            <p  style="height: 450px;text-align: justify;">
                {!! $info['aboutApp'] !!}
            </p>
        </div>
    </div>
@endsection
