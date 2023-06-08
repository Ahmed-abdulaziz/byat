@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.users')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.laundries.update', $user->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.about laundry')</label>
                            <textarea  class="form-control" name="about">{{$user->about}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.phone')</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="img" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/users/default.png') }}"  style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.Commercial record')</label>
                            <input type="file" name="Commercial_record" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/users/default.png') }}"  style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.password')</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>


                        <div class="form-group">
                            <label for="address_address">@lang('site.address')</label>
                            <input type="text" id="address-input" name="address_address" class="form-control map-input" required>
                            <input type="hidden" name="lat" id="address-latitude" value="0" />
                            <input type="hidden" name="long" id="address-longitude" value="0" />

                        </div>

                        <div id="address-map-container" style="width:100%;height:400px; ">
                            <div style="width: 100%; height: 100%" id="address-map"></div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
