@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.AboutAPP')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.AboutAPP')</a></li>
                <li class="active">@lang('site.AboutAPP')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.AboutAPP')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.aboutapp.update',$appSettings) }}" method="post">
                        <div class="box-body">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="col-md-8 form-group">
                            <label for="">@lang('site.AboutAPP in Arabic')</label>
                            <textarea type="text" name="aboutapp_ar" class="form-control ckeditor" id="" placeholder="@lang('site.AboutAPP in Arabic')">{!! $about->aboutapp_ar !!}</textarea>
                        </div>
                        <div class="col-md-8 form-group">
                            <label for="">@lang('site.AboutAPP in English')</label>
                            <textarea type="text" name="aboutapp_en" class="form-control ckeditor" id="" placeholder="@lang('site.AboutAPP in English')">{!! $about->aboutapp_en !!}</textarea>
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
