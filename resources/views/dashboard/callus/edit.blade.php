@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.callus')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.callus')</a></li>
                <li class="active">@lang('site.callus')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.callus')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.callus.update',$appSettings) }}" method="post">
                        <div class="box-body">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.facebook')</label>
                                <input type="text" name="facebook" class="form-control" value="{{$about->facebook}}" id="" placeholder="@lang('site.facebook')">
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.twwiter')</label>
                                <input type="text" name="twwiter" class="form-control" value="{{$about->twwiter}}" id="" placeholder="@lang('site.twwiter')">
                            </div>

                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.email')</label>
                                <input type="email" name="email" class="form-control" value="{{$about->email}}" id="" placeholder="@lang('site.email')">
                            </div>

                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.instgram')</label>
                                <input type="text" name="instgram" class="form-control" value="{{$about->instgram}}" id="" placeholder="@lang('site.instgram')">
                            </div>



                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.phone')</label>
                                <input type="number" name="phone" class="form-control" value="{{$about->phone}}" id="" placeholder="@lang('site.phone')">
                            </div>

                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.whatsapp')</label>
                                <input type="number" name="whatsapp" class="form-control" value="{{$about->whatsapp}}" id="" placeholder="@lang('site.whatsapp')">
                            </div>

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
