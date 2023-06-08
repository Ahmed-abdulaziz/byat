@extends('layouts.front')
@section('content')
    <div class="about-page">
        <div class="container my-5 about">
            <h2 class="my-5">@lang('site.Usage Policy')</h2>
            <p>
              {!! $info['usingPolicy'] !!}
            </p>
        </div>
    </div>
@endsection
